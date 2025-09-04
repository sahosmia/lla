<?php

namespace Amentotech\LaraGuppy\Http\Requests;

use Amentotech\LaraGuppy\ConfigurationManager;
use Amentotech\LaraGuppy\Rules\DifferentFromLoggedInUserId;

class FriendStoreRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'userId'         => ['required', 'integer', new DifferentFromLoggedInUserId],
            'friendStatus'   => ['nullable', 'in:'
                                    .ConfigurationManager::INVITED_STATUS.','
                                    .ConfigurationManager::ACTIVE_STATUS.','
                                    .ConfigurationManager::DECLINED_STATUS.','
                                    .ConfigurationManager::BLOCKED_STATUS.','
                                    .ConfigurationManager::UNBLOCKED_STATUS.','
                                    .ConfigurationManager::INVITE_BLOCKED_STATUS.','
                                    .ConfigurationManager::INVITE_UNBLOCKED_STATUS.''
                                ]
        ];
    }
}
