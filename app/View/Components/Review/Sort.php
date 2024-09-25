<?php

namespace App\View\Components\Review;

use Illuminate\View\Component;

use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\Schema;

use App\Models\Review;

class Sort extends Component
{
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
    public function __construct()
    { 
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
