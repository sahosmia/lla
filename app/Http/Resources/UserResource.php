<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id'                             => $this->whenHas('id'),
            'email'                          => $this->whenHas('email'),
            'status'                         => $this->whenHas('status'),
            'is_favorite'                    => $this->whenHas('is_favorite'),
            'avg_rating'                     => $this->whenHas('avg_rating'),
            'min_price'                      => $this->whenHas('min_price', function ($min_price) {
                return formatAmount($min_price);
            }),
            'total_reviews'                  => $this->whenHas('total_reviews'),
            'active_students'                => $this->whenHas('active_students'),
            'rating'                         => $this->whenHas('rating'),
            'image'                          => $this->whenHas('image'),
            'profile_completed'              => (($this->profile?->created_at ?? null) == ($this->profile?->updated_at ?? null) ? false : true),
            'comment'                        => $this->whenHas('comment'),
            'verified'                       => !empty($this->verfied_at) ? true : false,
            'subjects'                       => UserSubjectResource::collection($this->whenLoaded('subjects')),
            'reviews'                        => ReviewsResource::collection($this->whenLoaded('reviews')),
            'profile'                        => new ProfileResource($this->whenLoaded('profile')),
            'billingDetail'                  => new BillingDetailResource($this->whenLoaded('billingDetail')),
            'languages'                      => LanguageResource::collection($this->whenLoaded('languages')),
            'educations'                     => EducationResource::collection($this->whenLoaded('educations')),
            'address'                        => new AddressResource($this->whenLoaded('address')),
            'identityVerification'           => new IdentityResource($this->whenLoaded('identityVerification')),
            'role'                           => $this->whenHas('default_role'),
            'balance'                        => $this->whenLoaded('userWallet', function() {
                return formatAmount($this->userWallet?->amount ?? 0);
            })
        ];
    }
}
