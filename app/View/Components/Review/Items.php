<?php

namespace App\View\Components\Review;

use Illuminate\View\Component;

use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\Schema;

use App\Models\Review;

class Items extends Component
{
    public $reviews;
    public $is_reply;
    public $schema_org;
    public $total_rating;
    public $sum_reviews;
    public $sum_rating;
    public $user_likes = [];

    public $sorting_options = [
      "date_desc" => "Сначала самые новые",
      "date_asc" => "Сначала самые старые",
      "usefull_desc" => "Сначала полезные",
      "usefull_asc" => "Сначала бесполезные"
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($reviews = null, $isReply = false)
    { 
      $this->is_reply = $isReply;

      $key = config('app.name');

      $sort_string = \Request::input('reviews_sort', false);
      // 0 - index type, 1 - index direction
      $sort_array = $sort_string? explode('_', $sort_string): null;

      if($reviews) {
        $this->reviews = $reviews;
      }else {
        $this->reviews = Review::
            moderatedOrOwn()
          ->whereNull('parent_id')
          ->whereHas('landing', function($query) use ($key) {
            $query->where('key', $key);
          })
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
      }

      $this->sum_reviews = $this->reviews->count();
      $this->sum_rating =$this->reviews->whereNotNull('rating')->count();
      $this->total_rating = round($this->reviews->sum('rating') / $this->sum_reviews, 2);

      $this->user_likes = session('reviews_liked');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
      $business = ['name' => 'Spatie'];

      $this->schema_org = Schema::review()
        ->mainEntity(array_map(function($review) {
            return Schema::review()
              ->review($review['id'])
              ->author($review['author'])
              ->comment($review['text'])
              ->reviewRating($review['rating']);
        }, $this->reviews->toArray()));

      return view('components.review.items');
    }
}
