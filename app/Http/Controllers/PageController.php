<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\Schema;

use App\Models\Page;
use App\Models\Review;

class PageController extends Controller
{
  private $landing_key = null;

  public function __construct(){
    $this->landing_key = config('app.name');
  }
  
  /**
   * index
   *
   * @param  mixed $request
   * @return void
   */
  public function index(Request $request) {
    $key = $this->landing_key;

    $page = Page::
              where('is_home', true)
            ->whereHas('landing', function($query) use ($key) {
              $query->where('key', $key);
            })
            ->where('is_active', true)
            ->firstOrFail();

    if($page->is_reviews) {
      $reviews = $this->getReviews($page->id);
    } else {
      $reviews = [];
    }

    $schema_org = $this->getSchemaOrg($page, $reviews);

    return view('pages.index', [
      'page' => $page,
      'schema_org' => $schema_org,
      ...$reviews
    ]);
  }

  /**
   * page
   *
   * @param  mixed $request
   * @param  mixed $slug
   * @return void
   */
  public function page(Request $request, $slug) {
    $key = $this->landing_key;

    $page = Page::
        where('slug', $slug)
      ->whereHas('landing', function($query) use ($key) {
        $query->where('key', $key);
      })
      ->where('is_active', true)
      ->where('is_home', false)
      ->firstOrFail();

    if($page->is_reviews) {
      $reviews = $this->getReviews($page->id);
    } else {
      $reviews = [];
    }

    $schema_org = $this->getSchemaOrg($page, $reviews);

    return view('pages.page', [
      'page' => $page,
      'schema_org' => $schema_org,
      ...$reviews
    ]);
  }
    
  /**
   * getReviews
   *
   * @param  mixed $page
   * @return void
   */
  private function getReviews($page_id) {

    $key = config('app.name');

    $sort_string = \Request::input('reviews_sort', false);
    // 0 - index type, 1 - index direction
    $sort_array = $sort_string? explode('_', $sort_string): null;

    $reviews = Review::
        moderatedOrOwn()
      ->whereNull('parent_id')
      ->whereHas('landing', function($query) use ($key) {
        $query->where('key', $key);
      })
      ->where('page_id', $page_id)
      ->when($sort_array, function($query) use($sort_array) {
        switch($sort_array[0]){
          case 'date';
            $type = 'published_at';
            break;
          case 'usefull':
            $type = 'likes';
            break;
          default:
            $type = 'published_at';
        }

        $query->orderBy($type, $sort_array[1]);
      }, function($query){
        $query->orderBy('published_at', 'DESC');
      })
      ->get();


    $sum_reviews = $reviews->count();
    $sum_rating = $reviews->whereNotNull('rating')->count();
    $total_rating = $sum_reviews? round($reviews->sum('rating') / $sum_reviews): 0;

    return [
      'reviews' => $reviews,
      'sum_reviews' => $sum_reviews,
      'sum_rating' => $sum_rating,
      'total_rating' => $total_rating
    ];
  }

  /**
   * getSchemaOrg
   *
   * @param  mixed $page
   * @return void
   */
  private function getSchemaOrg($page = null, $reviews = null) {
    $schema_org = null;

    if(isset($page->extras['breadcrumbs']) && $page->extras['breadcrumbs'] === '1') {
      $items = [];
  
      $items[] = Schema::breadcrumbList()->name('Главная')->url(url('/'));
  
      if(!$page->is_home){
        $items[] = Schema::breadcrumbList()->name($page->name)->url(url('/' . $page->slug));
      }
      
      $schema_org = Schema::itemList()
        ->itemListElement($items);
    }

    if($reviews) {
      if($schema_org) {
        $schema_org = $schema_org->review();
      } else {
        $schema_org = Schema::review();
      }

      $schema_org = $schema_org
        ->mainEntity(array_map(function($review) {
            return Schema::review()
              ->review($review['id'])
              ->author($review['author'])
              ->comment($review['text'])
              ->reviewRating($review['rating']);
        }, $reviews['reviews']->toArray()))
        ->aggregateRating($reviews['total_rating']);
    }

    return $schema_org;
  }
}
