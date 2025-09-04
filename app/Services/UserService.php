<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use App\Models\AccountSetting;
use App\Models\Rating;

class UserService
{

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function addToFavourite($favouriteUserId)
    {
        $this->user?->favouriteUsers()->attach($favouriteUserId);
    }

    public function removeFromFavourite($favouriteUserId)
    {
        $this->user?->favouriteUsers()->detach($favouriteUserId);
    }

    public function removeFavouriteUser($favouriteUserId)
    {
        $this->user->favouriteUsers()->detach($favouriteUserId);
    }

    public function getFavouriteUsers()
    {
        return $this->user->favouriteUsers();
    }

    public function isFavouriteUser($userId)
    {
        return $this->user?->favouriteUsers()?->whereFavouriteUserId($userId)?->exists() ?? false;
    }

    public function setUserPassword(string $password): void
    {
        $hashedPassword = Hash::make($password);
        $this->user->update(['password' => $hashedPassword]);
    }

    public function getAccountSetting($key = null)
    {
        return $this->user->accountSetting()
            ->when($key, function ($query, $key) {
                return $query->where('meta_key', $key)->pluck('meta_value', 'meta_key');
            }, function ($query) {
                return $query->pluck('meta_value', 'meta_key');
            });
    }


    public function setAccountSetting($keys, $values = null)
    {
        if (is_array($keys)) {
            collect($keys)->each(function ($key, $index) use ($values) {
                $value = is_array($values) ? ($values[$index] ?? null) : null;
                $this->user->accountSetting()->updateOrCreate(
                    ['meta_key' => $key],
                    ['meta_key' => $key, 'meta_value' => $value]
                );
            });
        } else {
            $this->user->accountSetting()->updateOrCreate(
                ['meta_key' => $keys],
                ['meta_key' => $keys, 'meta_value' => $values]
            );
        }
    }

    public function removeAccountSettings($key)
    {
        return $this->user->accountSetting()->where('meta_key', $key)->delete();
    }

    public function getTutorRatings($userId, $rating = null)
    {
        $query = Rating::with([
            'profile.user.address.country:id,name,short_code'
        ])->where('tutor_id', $userId);

        if ($rating !== null) {
            $query->where('rating', $rating);
        }
        return $query->paginate(10);
    }

    public function getUser($id)
    {
        return User::where('id', $id)->first();
    }
}
