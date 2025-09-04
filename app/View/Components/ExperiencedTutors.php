<?php

namespace App\View\Components;

use App\Services\SiteService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
class ExperiencedTutors extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $siteService            = new SiteService();
        $experiencedTutors      = $siteService->featuredTutors();
        return view('components.experienced-tutors', compact('experiencedTutors'));
    }
}
