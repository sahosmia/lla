<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Casts\ConversationGroup;
class DisputeConversation extends Model
{
    protected $guarded = [];

    protected $casts = [
        'conversation_group' => ConversationGroup::class,
    ];

    public function dispute()
    {
        return $this->belongsTo(Dispute::class, 'dispute_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
