<?php

namespace Amentotech\LaraGuppy\Services;

use Amentotech\LaraGuppy\ConfigurationManager;
use Illuminate\Support\Facades\Storage;
class MyUser {

    public function extractUserInfo($user) {
        $userName = $userEmail = $userPhone = $userPhoto = $userId = null;

        $userFirstNameCol = (string)config('laraguppy.user_first_name_column');
        $userLastNameCol  = (string)config('laraguppy.user_last_name_column');
        $userEmailCol   = (string)config('laraguppy.user_email_column');
        $userImageCol   = (string)config('laraguppy.user_image_column');
        $userPhoneCol   = (string)config('laraguppy.user_phone_column');

        if (!empty($user)) {
            $userId = $user->id;
            $isMutedChat = $user?->chatActions?->map(function($action) use ($user) {
                return $action->user_id == $user->id && $action->action == ConfigurationManager::NOTIFICATION_MUTE;
            })?->first();
             if (!empty($user->chatProfile)) {
                return [
                    'name'      => $user->chatProfile->name,
                    'email'     => $user->chatProfile->email,
                    'phone'     => $user->chatProfile->phone,
                    'photo'     => $user->chatProfile->photo,
                    'userId'    => $userId,
                    'isMuted'   => $isMutedChat ?? false
                ];
            }

            $profile = $this->getActiveProfile($user);

            if ( (!empty($userFirstNameCol) || !empty($userLastNameCol) ) && !empty($profile)) {
                $userName = trim(($profile->$userFirstNameCol ?? null ).' '.($profile->$userLastNameCol));
            } elseif (!empty($userFirstNameCol) || !empty($userLastNameCol)) {
                $userName = trim(($user->$userFirstNameCol ?? null ).' '.($user->$userLastNameCol));
            } else {
                $userName = $user->name ?? null;
            }

            if (!empty($userEmailCol) && !empty($profile)) {
                $userEmail = $profile->$userEmailCol ?? null;
            } elseif (!empty($userEmailCol)) {
                $userEmail = $user->$userEmailCol ?? null;
            } else {
                $userEmail = $user->email ?? null;
            }

            if (!empty($userEmailCol) && !empty($profile)) {
                $userPhone = $profile->$userPhoneCol ?? null;
            } elseif (!empty($userEmailCol)) {
                $userPhone = $user->$userPhoneCol ?? null;
            } else {
                $userPhone = null;
            }

            if (!empty($userImageCol) && !empty($profile)) {
                $userPhoto = $profile->$userImageCol ?? null;
            } elseif (!empty($userImageCol)) {
                $userPhoto = $user->$userImageCol ?? null;
            } else {
                $userPhoto = null;
            }
        }
        return [
            'name'      => $userName,
            'email'     => $userEmail,
            'phone'     => $userPhone,
            'userId'    => $userId,
            'photo'     => !empty($userPhoto) ? url(Storage::url($userPhoto)) : null,
            'isMuted'   => $isMutedChat ?? false
        ];
    }

    public function getActiveProfile($user) {
        $profileRelation = config('laraguppy.userinfo_relation');
        if (!empty($profileRelation) && !empty($user->{$profileRelation})) {
            return $user->{$profileRelation};
        }
    }
}
