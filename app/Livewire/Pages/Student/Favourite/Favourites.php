<?php

namespace App\Livewire\Pages\Student\Favourite;

use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Favourites extends Component
{

    public $favourites;
    private $userService;
    public $isLoading = true;

    public function boot() {
        $this->userService  = new UserService(Auth::user());
    }

    public function loadData()
    {
        $this->isLoading            = false;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $this->favourites = $this->userService->getFavouriteUsers()
        ->with(['profile:id,user_id,slug,first_name,last_name,image,native_language',
                'address:id,addressable_id,addressable_type,country_id'])
        ->withAvg('reviews', 'rating')
        ->get();
        return view('livewire.pages.student.favourite.favourites');
    }


    #[On('remove-favourite-user')]
    public function removeFavouriteUser($params = [])
    {
        $this->userService->removeFavouriteUser($params['id']);
        $this->dispatch('showAlertMessage', type: 'success', title: __('general.alert_success_title') , message: __('general.alert_success_msg'));

    }

}

