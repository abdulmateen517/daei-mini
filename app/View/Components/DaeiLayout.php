<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class DaeiLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $title = null
    ) {}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.daei-app', [
            'title' => $this->title ?? 'Daei Mini — Islamic Productivity & Mentorship Platform',
        ]);
    }
}
