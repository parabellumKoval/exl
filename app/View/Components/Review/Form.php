<?php

namespace App\View\Components\Review;

use Illuminate\View\Component;

class Form extends Component
{
    public $replyId = null;
    public $pageId = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($replyId = null, $pageId = null)
    {
        $this->replyId = $replyId;
        $this->pageId = $pageId;
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
