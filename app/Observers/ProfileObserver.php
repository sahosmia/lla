<?php

namespace App\Observers;

use App\Models\Profile;
use Illuminate\Support\Str;

class ProfileObserver {
    /**
     * Handle the Profile "creating" event.
     *
     * @param  \App\Models\Profile  $profile
     * @return void
     */
    public function saving(Profile $profile) {
        $slug = Str::slug($profile->first_name . '-' . $profile->last_name);
        $profile->slug = $this->uniqueSlug($slug, $profile->id);
    }
    protected function uniqueSlug($slug, $profileId = null, $i = 0) {
        if (Profile::whereSlug($slug)->where('id', '!=', $profileId)->exists()) {
            $slug = Str::of($slug)->rtrim('-' . $i) . '-' . ++$i;
            return $this->uniqueSlug($slug, $profileId, $i);
        }
        return $slug;
    }
}
