<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                          => $this->whenHas('id'),
            'student_id '                 => $this->whenHas('student_id '),
            'amount'                      => $this->whenHas('amount', function ($amount) {
                return formatAmount($amount);
            }),
            'transaction_id'              => $this->whenHas('transaction_id'),
            'used_wallet_amt'             => $this->whenHas('used_wallet_amt'),
            'sales_tax'                   => $this->whenHas('sales_tax'),
            'currency'                    => $this->whenHas('currency'),
            'first_name'                  => $this->whenHas('first_name'),
            'last_name'                   => $this->whenHas('last_name'),
            'company'                     => $this->whenHas('company'),
            'country'                     => $this->whenHas('country'),
            'state'                       => $this->whenHas('state'),
            'postal_code'                 => $this->whenHas('postal_code'),
            'city'                        => $this->whenHas('city'),
            'phone'                       => $this->whenHas('phone'),
            'email'                       => $this->whenHas('email'),
            'payment_method'              => $this->whenHas('payment_method'),
            'description '                => $this->whenHas('description'),
            'status'                      => $this->whenHas('status'),
            'created_at'                  => $this->whenHas('created_at'),
            'updated_at'                  => $this->whenHas('updated_at'),
        ];

    }
}
