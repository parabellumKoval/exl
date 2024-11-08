<?php

namespace App\View\Components\Review;

use Illuminate\View\Component;

use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\Schema;

use App\Models\Review;

class Sort extends Component
{
    public $sorting_options = [];
    public $strings = null;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($landing = null, $strings = null)
    { 
      $this->strings = $strings;

      $this->sorting_options = [
        "date_desc" => $strings['review_sort_date_desc'],
        "date_asc" => $strings['review_sort_date_asc'],
        "usefull_desc" => $strings['review_sort_usefull_desc'],
        "usefull_asc" => $strings['review_sort_usefull_asc']
      ];
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
