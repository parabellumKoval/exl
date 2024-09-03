<?php

namespace App\View\Components\Review;

use Illuminate\View\Component;

use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\Schema;

use App\Models\Review;

class Items extends Component
{
    public $reviews;
    public $schema_org;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
      $key = config('app.name');
      
      $this->reviews = Review::where('is_moderated', 1)->whereHas('landing', function($query) use ($key) {
        $query->where('key', $key);
      })->get();
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
