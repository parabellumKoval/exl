<?php

namespace App\View\Components\Review;

use Illuminate\View\Component;

class Total extends Component
{
    public $total_rating;
    public $sum_reviews;
    public $sum_rating;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($sumReviews = 0, $totalRating = 0, $sumRating = 0)
    { 
      $this->sum_reviews = $sumReviews;
      $this->sum_rating = $sumRating;
      $this->total_rating = $totalRating;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
      return view('components.review.total');
    }
}
