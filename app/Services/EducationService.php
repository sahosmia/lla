<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserEducation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class EducationService {

    public $user;

    public function __construct($user) {
        $this->user = $user;
    }

    public function getUserEducations(): Collection {
        return $this->user->educations()->with('country')->get();
    }

    public function getUserEducation($educationId) {
        return $this->user->educations()->whereId($educationId)->first();
    }

    public function setUserEducation($education) {
        if ($education) {
            $education['start_date'] = Carbon::parse($education['start_date']);
            if (!empty($education['end_date'])){
                $education['end_date'] = Carbon::parse($education['end_date']);
            }
            $isUpdate           = !empty($education['id']);
            $updatedEducation   = $this->user->educations()->updateOrCreate(['id' => $education['id'] ?? null], $education);
            if (request()->is('api/*')) {
                return $updatedEducation;
            } else {
                return $isUpdate ? 'updated' : 'created';
            }
        }
    }

    public function deleteEducation($educationId): bool {
        $education = $this->user->educations()->whereId($educationId)->first();

        if ($education) {
            $education->delete();
            return true;
        } else
            return false;
    }
}
