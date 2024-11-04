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
    public $strings = null;
    
    public $user_likes = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($reviews = null, $isReply = false, $strings = null)
    { 
      $this->is_reply = $isReply;
      $this->reviews = $reviews;
      $this->strings = $strings;

      $this->user_likes = session('reviews_liked');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
      return view('components.review.items');
    }
}
