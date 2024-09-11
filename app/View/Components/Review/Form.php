<?php

namespace App\View\Components\Review;

use Illuminate\View\Component;

class Form extends Component
{
    public $replyId = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($replyId = null)
    {
        $this->replyId = $replyId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.review.form');
    }
}
