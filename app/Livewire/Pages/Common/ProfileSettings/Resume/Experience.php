<?php

namespace App\Livewire\Pages\Common\ProfileSettings\Resume;

use App\Livewire\Forms\Tutor\Experience\UserExperienceForm;
use App\Models\Country;
use App\Services\ExperienceService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\On;

class Experience extends Component
{
    public UserExperienceForm $form;
    public $updateMode          = false;
    public $countries           = null;
    public $MAX_PROFILE_CHAR    = 500;
    public $experiences         = [];
    public $activeRoute         = '';
    public $isLoading           = true;
    public $routes              = '';
    protected $experiencesService;

    public function boot() {
        $this->experiencesService = new ExperienceService(Auth::user());
    }

    public function loadData()
    {
        $this->isLoading            = false;
        $this->dispatch('loadPageJs');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        if ($this->getErrorBag()->any()) {
            $this->dispatch('loadPageJs');
        }
        $this->experiences  = $this->experiencesService->getUserExperiences();
        return view('livewire.pages.common.profile-settings.resume.experience');
    }

    public function mount(): void
    {
        $this->activeRoute  = Route::currentRouteName();
        $this->routes = [
            [
                'icon' => '<i><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M3.3335 15.6667C3.3335 13.4575 5.12436 11.6667 7.3335 11.6667H12.6668C14.876 11.6667 16.6668 13.4575 16.6668 15.6667V15.6667C16.6668 17.1394 15.4729 18.3333 14.0002 18.3333H6.00016C4.5274 18.3333 3.3335 17.1394 3.3335 15.6667V15.6667Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M13.3335 5.00001C13.3335 6.84095 11.8411 8.33334 10.0002 8.33334C8.15921 8.33334 6.66683 6.84095 6.66683 5.00001C6.66683 3.15906 8.15921 1.66667 10.0002 1.66667C11.8411 1.66667 13.3335 3.15906 13.3335 5.00001Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></i>',
                'title' => 'Education',
                'route' => 'tutor.profile.resume.education',
            ],
            [
                'icon' => '<i><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M0.833496 0.833394L1.25016 0.833344V0.833344C2.48332 0.833374 3.56706 1.65086 3.90583 2.83657L4.04778 3.33339M4.04778 3.33339L5.3406 7.85828C5.816 9.52215 6.05369 10.3541 6.53896 10.9716C6.96727 11.5166 7.52988 11.941 8.17161 12.2031C8.89867 12.5001 9.7639 12.5001 11.4944 12.5001H12.5097C13.5595 12.5001 14.0843 12.5001 14.544 12.3899C15.6414 12.1269 16.5766 11.4125 17.1191 10.423C17.3463 10.0086 17.4844 9.50219 17.7606 8.48945V8.48945C18.0971 7.25575 18.2653 6.6389 18.2327 6.13844C18.1541 4.93155 17.3585 3.8899 16.2148 3.49652C15.7406 3.33339 15.1012 3.33339 13.8225 3.33339H4.04778ZM10.0002 16.6667C10.0002 17.5872 9.25397 18.3333 8.3335 18.3333C7.41302 18.3333 6.66683 17.5872 6.66683 16.6667C6.66683 15.7462 7.41302 15 8.3335 15C9.25397 15 10.0002 15.7462 10.0002 16.6667ZM16.6668 16.6667C16.6668 17.5872 15.9206 18.3333 15.0002 18.3333C14.0797 18.3333 13.3335 17.5872 13.3335 16.6667C13.3335 15.7462 14.0797 15 15.0002 15C15.9206 15 16.6668 15.7462 16.6668 16.6667Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></i>',
                'title' => 'Experience',
                'route' => 'tutor.profile.resume.experience',
            ],
            [
                'icon' => '<i><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M2.08317 6.66667H17.9165M4.99984 10H8.33317M8.06651 17.5H11.9332C14.1734 17.5 15.2935 17.5 16.1491 17.064C16.9018 16.6805 17.5137 16.0686 17.8972 15.316C18.3332 14.4603 18.3332 13.3402 18.3332 11.1V8.9C18.3332 6.65979 18.3332 5.53968 17.8972 4.68404C17.5137 3.93139 16.9018 3.31947 16.1491 2.93597C15.2935 2.5 14.1734 2.5 11.9332 2.5H8.0665C5.82629 2.5 4.70619 2.5 3.85054 2.93597C3.09789 3.31947 2.48597 3.93139 2.10248 4.68404C1.6665 5.53968 1.6665 6.65979 1.6665 8.9V11.1C1.6665 13.3402 1.6665 14.4603 2.10248 15.316C2.48597 16.0686 3.09789 16.6805 3.85054 17.064C4.70619 17.5 5.82629 17.5 8.06651 17.5Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></i>',
                'title' => 'Certificates & Awards',
                'route' => 'tutor.profile.resume.certificate',
            ]
        ];
    }

    public function getTypes( $id = null)
    {
        $result= [];
        $types = [
            ''              => __('general.select_type'),
            'full_time'     => __('experience.full_time'),
            'part_time'     => __('experience.part_time'),
            'self_employed' => __('experience.self_employed'),
            'contract'      => __('experience.contract'),
        ];

        foreach($types as $value => $name){
            $result[] = [
                'id' => $value,
                'text' => htmlspecialchars_decode($name),
                'selected' => $value == $id
            ];

        }
        
        return $result;
    }

    public function getLocations( $id = null)
    {
        $result= [];
        $locations = [
            ''       => __('general.select_type'),
            'onsite' => __('experience.onsite'),
            'remote' => __('experience.remote'),
            'hybrid' => __('experience.hybrid'),
        ];

        foreach($locations as $value => $name){
            $result[] = [
                'id' => $value,
                'text' => htmlspecialchars_decode($name),
                'selected' => $value == $id
            ];
        }

        return $result;
    }

    public function getCountries( $id = null)
    {
        $countries  = Country::get(['id','name']);
        $result = [
            [
                'id' => '',
                'text' => __('general.select_country')
            ]
        ];
        if($countries?->isNotEmpty()){
            foreach($countries as $country){
                $result[] = [
                    'id' => $country->id,
                    'text' => htmlspecialchars_decode($country->name),
                    'selected' => $id == $country->id
                ];
            }
        }
        return $result;
    }


    public function storeExperience(){
        $experience     = $this->form->validateExperience();
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            $this->dispatch('toggleModel', id:'experience-popup', action:'hide');
            return;
        }
        $status         = $this->experiencesService->setUserExperience($experience);
        $this->dispatch('toggleModel', id:'experience-popup', action:'hide');
        $this->updateMode   = false;

        if ($status === 'created') {
            $this->dispatch('showAlertMessage', type: 'success', title: __('experience.title') , message: __('experience.experience_added_message'));
        } else {
            $this->dispatch('showAlertMessage', type: 'success', title: __('experience.title') , message: __('experience.experience_edit_message'));
        }
    }


    public function addExperience() {
        $this->countries    = Country::get(['id','name']);
        $this->form->setExperience();
        $this->resetErrorBag();
        $this->form->reset();
        $this->updateMode   = false;

        $data = [
            'countries' => $this->getCountries(),
            'locations' => $this->getLocations(),
            'types' => $this->getTypes(),
        ];

        $this->dispatch('initMutliDropDown', data: $data );
        $this->dispatch('toggleModel', id:'experience-popup', action:'show');
    }

    public function editExperience($experience) {
        $this->countries    = Country::get(['id','name']);
        $this->form->setExperience($experience);
        $this->resetErrorBag();
        $this->updateMode   = true;
        $data = [
            'countries' => $this->getCountries($experience['country_id']),
            'locations' => $this->getLocations($experience['location']),
            'types' => $this->getTypes($experience['employment_type']),
        ];
        $this->dispatch('initMutliDropDown', data: $data, countries_id: $experience['country_id'], locations_id: $experience['location'], types_id: $experience['employment_type'] );
        $this->dispatch('toggleModel', id:'experience-popup', action:'show');
    }

    #[On('delete-experience')]
    public function deleteExperience($params = []) {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $deleted     = $this->experiencesService->deleteExperience($params['id']);
        if ($deleted) {
            $this->dispatch('showAlertMessage', type: 'success', title: __('experience.title') , message: __('experience.experience_deleted_message'));
        }

    }
}
