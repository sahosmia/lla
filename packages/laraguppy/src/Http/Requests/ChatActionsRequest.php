<?php

namespace Amentotech\LaraGuppy\Http\Requests;

use Amentotech\LaraGuppy\ConfigurationManager;

class ChatActionsRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'threadId' => ['required', 'integer', 'exists:' . config('laraguppy.db_prefix') . ConfigurationManager::MESSAGES_TABLE . ',thread_id'],
            'action' => [ 'nullable', 'in:'.ConfigurationManager::CLEAR_CHAT_ACTION ]
        ];
    }
}
