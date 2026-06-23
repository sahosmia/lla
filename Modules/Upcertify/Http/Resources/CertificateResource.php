<?php

namespace Modules\Upcertify\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CertificateResource extends JsonResource
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
            'title'                 => $this->template?->title ?? '',
            'certificate_for'       => $this->wildcard_data['course_title'] ?? $this->wildcard_data['subject_name'] ?? 'N/A',
            'assigned_at'           => $this->created_at->format(setting('_general.date_format')) ?? 'N/A',
            'issued_by'             => $this->wildcard_data['tutor_name'] ?? "N/A",
            'view_link'             => route('upcertify.certificate', ['uid' => $this->hash_id, 'actions' => 'hide']),
            'download_link'         => route('upcertify.download', ['uid' => $this->hash_id]),
        ];
    }
}
