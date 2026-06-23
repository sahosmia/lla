<?php

namespace App\Livewire\Components;

use App\Http\Requests\Student\Booking\SendMessageRequest;
use App\Models\User;
use App\Services\SiteService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class SimilarTutors extends Component
{

    public  $user;
    public  $allowFavAction = false;
    private $userService;
    public $similarTutors;
    public $recepientId;

    public function boot() {

        $user = Auth::user();
        $this->userService = new UserService($user);
    }

    public function mount($user){
        $this->user = $user;
        if(Auth::user()?->role == 'student'){
            $this->allowFavAction = true;
        }
    }

    public function placeholder(array $params = [])
    {
        $repeatItems = 10;
        return view('skeletons.related-tutors', compact('repeatItems'));
    }

    public function getMatchingInstructors($user) {
        $siteService            = new SiteService();
        $this->similarTutors    = $siteService->getMatchingInstructors($user);
    }

    public function render()
    {
        $this->getMatchingInstructors($this->user);

        $favouriteTutors = array();
        if ( $this->allowFavAction){
            $favouriteTutors = $this->userService->getFavouriteUsers()->get(['favourite_user_id'])?->pluck('favourite_user_id')->toArray();
        }
        return view('livewire.components.similar-tutors',compact('favouriteTutors'));
    }

}
