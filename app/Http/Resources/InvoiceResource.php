<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                            => $this->whenHas('id'),
            'order_id'                      => $this->whenHas('order_id'),
            'subject'                       => $this->whenHas('title'),
            'avg_rating'                    => $this->whenHas('avg_rating'),
            'price'                         => $this->whenHas('price', function ($price) {
                return formatAmount($price);
            }),
            'created_at'                    => $this->whenHas('created_at', function () {
                return \Carbon\Carbon::parse($this->created_at)->format(!empty(setting('_general.date_format')) ? setting('_general.date_format') : 'M d, Y');
            }),
            'status'                        => $this->whenLoaded('orders', function () {
                return $this->orders->status;
            }),
            'transaction_id'                => $this->whenLoaded('orders', function () {
                return $this->orders->transaction_id;
            }),
            'tutor_name'                    => $this->whenLoaded('orderable', function () {
                return $this->orderable?->tutor?->full_name;
            }),
        ];
    }
}
