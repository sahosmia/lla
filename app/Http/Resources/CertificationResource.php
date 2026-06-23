<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
class CertificationResource extends JsonResource
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
            'title'                 => $this->whenHas('title'),
            'user_id'               => $this->whenHas('user_id'),
            'image'                 => !empty($this->image) ? url(Storage::url($this->image)) : url(Storage::url('placeholder.png')),
            'institute_name'        => $this->whenHas('institute_name'),
            'issue_date'            => $this->whenHas('issue_date', function () {
                return \Carbon\Carbon::parse($this->issue_date)->format('M d, Y');
            }),

            'expiry_date'            => $this->whenHas('expiry_date', function () {
                return \Carbon\Carbon::parse($this->expiry_date)->format('M d, Y');
            }),
            'formatted_issue_date'    => $this->whenHas('issue_date', function () {
                return \Carbon\Carbon::parse($this->issue_date)->format(!empty(setting('_general.date_format')) ? setting('_general.date_format') : 'M d, Y');
            }),

            'formatted_expiry_date'    => $this->whenHas('expiry_date', function () {
                return \Carbon\Carbon::parse($this->expiry_date)->format(!empty(setting('_general.date_format')) ? setting('_general.date_format') : 'M d, Y');
            }),

            'description'           => $this->whenHas('description'),
        ];
    }
}
