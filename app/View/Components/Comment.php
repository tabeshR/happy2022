<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Comment extends Component
{
    public $route;
    public $subject_id;
    public $subject_type;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($route,$subjectId,$subjectType)
    {
        $this->route = $route;
        $this->subject_id= $subjectId;
        $this->subject_type = $subjectType;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.comment');
    }
}
