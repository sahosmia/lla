<?php

namespace App\Models;

use App\Casts\DisputeStatus;
use Illuminate\Database\Eloquent\Model;
use App\Models\SlotBooking;
use App\Models\DisputeConversation;
class Dispute extends Model
{
    protected $guarded = [];

    protected $casts = [
        'status' => DisputeStatus::class,
    ];

    public function disputable()
    {
        return $this->morphTo();
    }

    public function responsibleBy()
    {
        return $this->belongsTo(User::class, 'responsible_by');
    }

    public function creatorBy()
    {
        return $this->belongsTo(User::class, 'creator_by');
    }

    public function favourTo()
    {
        return $this->belongsTo(User::class, 'favour_to');
    }

    public function resolvedBy()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    public function booking()
    {
        return $this->belongsTo(SlotBooking::class, 'disputable_id');
    }

    public function disputeConversations()
    {
        return $this->hasMany(DisputeConversation::class);
    }
}
