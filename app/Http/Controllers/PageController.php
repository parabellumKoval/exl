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

    $page = Page::where('is_home', true)->whereHas('landing', function($query) use ($key) {
      $query->where('key', $key);
    })->first();

    $schema_org = $this->getSchemaOrg();

    return view('pages.index', [
      'page' => $page,
      'schema_org' => $schema_org
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

    $page = Page::where('slug', $slug)->whereHas('landing', function($query) use ($key) {
      $query->where('key', $key);
    })->where('is_home', false)->firstOrFail();

    $schema_org = $this->getSchemaOrg($page);

    return view('pages.page', [
      'page' => $page,
      'schema_org' => $schema_org
    ]);
  }
  
  /**
   * getSchemaOrg
   *
   * @param  mixed $page
   * @return void
   */
  private function getSchemaOrg($page = null) {
    $items = [];

    $items[] = Schema::breadcrumbList()->name('Главная')->url(url('/'));

    if($page){
      $items[] = Schema::breadcrumbList()->name($page->name)->url(url('/' . $page->slug));
    }
    
    $schema_org = Schema::itemList()
      ->itemListElement($items);

    return $schema_org;
  }
}
