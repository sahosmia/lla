<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ExperienceService {

    public $user;

    public function __construct($user) {
        $this->user = $user;
    }

    public function getUserExperiences(): Collection {
        return $this->user->experiences()->with('country')->get();
    }

    public function setUserExperience($experience) {
        if ($experience) {
            $experience['start_date'] = Carbon::parse($experience['start_date']);
            if (!empty($experience['end_date'])){
                $experience['end_date'] = Carbon::parse($experience['end_date']);
            }
            $isUpdate           = !empty($experience['id']);
            $updatedExperience  = $this->user->experiences()->updateOrCreate(['id' => $experience['id'] ?? null], $experience);
            if (request()->is('api/*')) {
                return $updatedExperience;
            } else{
                return $isUpdate ? 'updated' : 'created';
            }
        }
    }

    public function deleteExperience($experienceId): bool {
        $experience = $this->user->experiences()->whereId($experienceId)->first();

        if ($experience) {
            $experience->delete();
            return true;
        } else
            return false;
    }

    public function getUseExperience($educationId) {
        return $this->user->experiences()->whereId($educationId)->first();
    }
}
