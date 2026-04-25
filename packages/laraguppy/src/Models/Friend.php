<?php

namespace Amentotech\LaraGuppy\Models;

use Amentotech\LaraGuppy\ConfigurationManager;
use Amentotech\LaraGuppy\Models\Scopes\ActiveScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Friend extends Model {
    use HasFactory;

    protected $table;

    protected $fillable = ['user_id', 'friend_id', 'friend_status', 'blocked_by', 'created_at', 'updated_at'];

    public function __construct() {
        $this->table = config('laraguppy.db_prefix') . ConfigurationManager::FRIENDS_TABLE;
        parent::__construct();
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new ActiveScope('friend_status'));
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Get riend's thread.
     */
    public function thread(): HasOneThrough
    {
        return $this->hasOneThrough(Thread::class, Participant::class, 'participantable_id', 'id');
    }
}
