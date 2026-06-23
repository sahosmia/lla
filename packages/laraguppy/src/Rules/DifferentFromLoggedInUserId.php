<?php

namespace Amentotech\LaraGuppy\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class DifferentFromLoggedInUserId implements Rule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function validate($attribute, $value, $fail)
    {
        if (Auth::id() == $value) {
            $fail('The selected :attribute must be different from the currently logged in user.');
        }
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Auth::id() != $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selected :attribute must be different from the currently logged in user.';
    }
}
