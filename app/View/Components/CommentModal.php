<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CommentModal extends Component
{
    public $post;

    public function __construct($post)
    {
        $this->post = $post;
    }

    public function render(): View|Closure|string
    {
        return view('components.comment-modal');
    }
}
