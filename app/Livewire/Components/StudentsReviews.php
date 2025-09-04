<?php

namespace App\Livewire\Components;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class StudentsReviews extends Component
{
    use WithPagination;
    public $user;
    public $paginate = '5';

    public function mount($user)
    {
        $this->dispatch('initSelect2', target: '.am-select2' );
        $this->user = $user;
    }

    public function placeholder()
    {
        return view('skeletons.tutor-reviews');
    }

    public function render()
    {
        $allRatings = range(1, 5);
        $allTutorRatings = Rating::with([
            'profile.user' => function($query) {
                $query->select('id');
            },
            'profile.user.address' => function($query) {
                    $query->with( 'country');
            }
        ])
        ->where('tutor_id',$this->user->id)->paginate($this->paginate);

        $tutorRatings       = Rating::where('tutor_id',$this->user->id)->get();
        $tutorAvgRatings    = $tutorRatings->avg('rating');
        $tutorRatingsCount  = $tutorRatings->countBy('rating');
        $tutorReviewCount   = $tutorRatings->count('rating');
        foreach ($allRatings as $rating) {
            if (!isset($tutorRatingsCount[$rating])) {
                $tutorRatingsCount[$rating] = 0;
            }
        }
        $tutorRatingsCount = $tutorRatingsCount->sortKeysDesc();
        return view('livewire.components.students-reviews',compact('tutorRatings','allTutorRatings','tutorAvgRatings','tutorRatingsCount','tutorReviewCount'));
    }
}
