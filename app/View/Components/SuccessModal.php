<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SuccessModal extends Component
{
    /**
     * Create a new component instance.
     */
    public $message;
    
    public function __construct($message = null)
    {
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.success-modal');
    }
}
