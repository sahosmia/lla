<?php

namespace App\View\Components;

use App\Models\Profile;
use App\Services\SiteService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class FeaturedTutors extends Component
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
        $featuredTutors         = $siteService->featuredTutors();
        return view('components.featured-tutors', compact('featuredTutors'));
    }
}
