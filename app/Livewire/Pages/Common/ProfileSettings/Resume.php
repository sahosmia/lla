<?php

namespace App\Livewire\Pages\Common\ProfileSettings;

use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Resume extends Component
{
    public $activeRoute = '';
    public $routes = '';

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.common.profile-settings.resume');
    }

    public function mount(): void
    {
        $this->activeRoute = Route::currentRouteName();

        $this->routes = [
            [
                'icon' => '<i class="am-icon-user-01"></i>',
                'title' => 'Education',
                'route' => 'tutor.profile.resume.education',
            ],
            [
                'icon' => '<i class="am-icon-shopping-basket-04"></i>',
                'title' => 'Experience',
                'route' => 'tutor.profile.resume.experience',
            ],
            [
                'icon' => '<i class="am-icon-atm-card-02"></i>',
                'title' => 'Certificates & Awards',
                'route' => 'tutor.profile.resume.certificate',
            ]
        ];
    }
}
