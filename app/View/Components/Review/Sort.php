<?php

namespace App\View\Components\Review;

use Illuminate\View\Component;

use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\Schema;

use App\Models\Review;

class Sort extends Component
{
    public $sorting_options = [];


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($landing = null)
    { 
      if($landing) {
        $this->sorting_options = [
          "date_desc" => $landing->strings['review_sort_date_desc'],
          "date_asc" => $landing->strings['review_sort_date_asc'],
          "usefull_desc" => $landing->strings['review_sort_usefull_desc'],
          "usefull_asc" => $landing->strings['review_sort_usefull_asc']
        ];
      }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
      return view('components.review.sort');
    }
}
