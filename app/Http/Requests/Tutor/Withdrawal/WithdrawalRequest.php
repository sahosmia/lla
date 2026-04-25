<?php

namespace App\Http\Requests\Tutor\Withdrawal;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BaseFormRequest;

class WithdrawalRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = Auth::user();
        $balance = $user->userWallet->amount ?? 0;
        return [
            'amount' => [
                'required',
                'numeric',
                'min:100',
                'max:' . $balance,
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        $balance = Auth::user()->userWallet->amount ?? 0;

        return [
            'amount.min' => 'The withdrawal amount must be at least ' . formatAmount(100) . '.',
            'amount.max' => 'The withdrawal amount may not be greater than ' . formatAmount($balance) . '.',
        ];
    }
}
