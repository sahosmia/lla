<?php

namespace Amentotech\LaraGuppy\Models;

use Amentotech\LaraGuppy\ConfigurationManager;
use Amentotech\LaraGuppy\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

class Participant extends Model {
    use HasFactory, SoftDeletes;

    protected $table;

    public $fillable = ['thread_id', 'participantable_id', 'participantable_type',  'last_read', 'role', 'participant_status', 'created_at', 'updated_at'];

    public function __construct() {
        $this->table = config('laraguppy.db_prefix') . ConfigurationManager::PARTICIPANTS_TABLE;
        parent::__construct();
    }
    
    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new ActiveScope('participant_status'));
    }

    /**
     * Get the thread participant.
     */
    public function participantable(): MorphTo
    {
        return $this->morphTo();
    }


    /**
     * @return BelongsTo|Thread
     */
    public function thread():  BelongsTo{
        return $this->BelongsTo(Thread::class);
    }

    /**
     * Scope for participant that is a creator.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeCreator(Builder $query): Builder {
        return $query->whereRole('creator');
    }

    /**
     * Scope for participants that are admins.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeAdmins(Builder $query): Builder {
        return $query->whereRole('admin');
    }

    /**
     * Scope for participants that are active.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder {
        return $query->participant_status('active');
    }

    /**
     * Scope for participants that have left the group.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeLeft(Builder $query): Builder {
        return $query->participant_status('left');
    }

    /**
     * Scope for participants that are blocked.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeBlocked(Builder $query): Builder {
        return $query->participant_status('blocked');
    }

    /**
     * Get the user associated with the Participant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne {
        return $this->hasOne(config('auth.providers.users.model'), 'id', 'participantable_id')->with( 'chatProfile');
    }
}
