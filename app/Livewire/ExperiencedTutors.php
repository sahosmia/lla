<?php

namespace App\Livewire;

use App\Services\SiteService;
use App\Services\UserService;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExperiencedTutors extends Component
{
    public  $user;
    private $userService;
    public $sectionVerient;
    public $viewProfileBtn;
    public $viewProfileBtnUrl;
    public $selectTutor;
    public $slider;
    
    public function mount($sectionVerient, $viewProfileBtn, $viewProfileBtnUrl, $selectTutor, $slider = false)
    {
        $this->sectionVerient       = $sectionVerient;
        $this->viewProfileBtn       = $viewProfileBtn;
        $this->viewProfileBtnUrl    = $viewProfileBtnUrl;
        $this->selectTutor          = $selectTutor;
        $this->slider               = $slider;
    }
    
    public function boot() {
        $user = Auth::user();
        $this->userService = new UserService($user);
    }

    public function render()
    { 
        
        $siteService            = new SiteService();
        $experiencedTutors      = $siteService->featuredTutors();

        $favouriteTutors        = array();
        if (Auth::check()) {
            $favouriteTutors = $this->userService->getFavouriteUsers()->pluck('favourite_user_id')->toArray();
        }
        return view('livewire.experienced-tutors', compact('experiencedTutors', 'favouriteTutors'));
    }
    public function favouriteTutor($tutorId){
        $user = Auth::user();
        $exists = DB::table('favourite_users')
            ->where('user_id', $user->id)
            ->where('favourite_user_id', $tutorId)
            ->exists();
        if (!$exists) {
            DB::table('favourite_users')->insert([
                'user_id' => $user->id,
                'favourite_user_id' => $tutorId,
            ]);
        }
        DB::disconnect();
    }
}
