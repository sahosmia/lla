<?php

namespace App\Livewire\Pages\Admin\Reviews;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use App\Models\Rating;
use Livewire\WithPagination;

class Reviews extends Component
{
    use WithPagination;

    public $paginate    = '10';
    public $sortby      = 'desc';
    public $search      = '';

    #[Layout('layouts.admin-app')]
    public function render()
    {
        $allRatings = range(1, 5);

        $query = Rating::with(['profile.user:id', 'tutor.profile', 'ratingable']);
    
        $query->where(function ($q) {
            if (!empty($this->search)) {
                $q->whereHas('profile.user', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%');
                })->orWhereHas('tutor.profile', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
            }
        });

        $query->orderBy('id', $this->sortby);
 
        $allTutorReviews = $query->paginate($this->paginate);

        $allTutorReviews->getCollection()->each(function ($rating) {
            if ($rating->ratingable_type === Modules\Courses\Models\Course::class) {
                $rating->ratingable->load('media');
            } elseif ($rating->ratingable_type === App\Models\SlotBooking::class) {
                $rating->ratingable->load('slot.subjectGroupSubjects.subject');
            }
        });

        return view('livewire.pages.admin.reviews.reviews', compact('allTutorReviews'));
    }

    public function mount()
    {
        $this->dispatch('initSelect2', target: '.am-select2');
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'sortby'])) {
            $this->resetPage();
        }
    }

    #[On('delete-review')]
    public function deleteReview($params = [])
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        $review = Rating::find($params['id']);
        if (empty($review)) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.error_title'), message: __('settings.no_record_exists'));
            return;
        }
        $review->delete();
        $this->dispatch('showAlertMessage', type: 'success', message: __('general.delete_review_message'));
    }
}
