<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayoutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->whenHas('id'),
            'user_id'               => $this->whenHas('user_id'),
            'amount'                => $this->whenHas('amount', function ($amount) {
                return formatAmount($amount);
            }),
            'payout_method'         => $this->whenHas('payout_method'),
            'detail'                => $this->whenHas('detail', $this['detail'] ?? null),
            'payout_details'        => $this->whenHas('payout_details', $this['payout_details'] ?? null),
            'status'                => $this->whenHas('status'),
            'created_at'            => $this->whenHas('created_at', function ($created_at) {
                return Carbon::parse($created_at)->format(!empty(setting('_general.date_format')) ? setting('_general.date_format') : 'M d, Y');
            }),
            'updated_at'            => $this->whenHas('updated_at', function ($updated_at) {
                return Carbon::parse($updated_at)->format(!empty(setting('_general.date_format')) ? setting('_general.date_format') : 'M d, Y');
            })
        ];
    }
}
