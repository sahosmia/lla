<?php

namespace Amentotech\LaraGuppy\Http\Requests;

use Amentotech\LaraGuppy\ConfigurationManager;

class NotificationActionsRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'action'     => ['required', 
                                'in:'
                                .ConfigurationManager::NOTIFICATION_MUTE.','
                                .ConfigurationManager::NOTIFICATION_UNMUTE.','
                            ]
        ];
    }
}
