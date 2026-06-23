<?php

namespace Amentotech\LaraGuppy\Models;

use Amentotech\LaraGuppy\ConfigurationManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Amentotech\LaraGuppy\Models\ChatAction;
use Amentotech\LaraGuppy\Services\MyUser;
class Thread extends Model {
    use HasFactory, SoftDeletes;

    protected $table;

    protected $creatorCache;

    public $fillable = ['name', 'thread_type', 'created_at', 'updated_at'];

    public function __construct() {
        $this->table = config('laraguppy.db_prefix') . ConfigurationManager::THREADS_TABLE;
        parent::__construct();
    }

    /**
     * @return HasMany|Participant|Collection
     */
    public function participants(): HasMany {
        return $this->hasMany(Participant::class)->whereNot('participantable_id', auth()->user()->id);
    }

    /**
     * @return HasMany|Participant|Collection
     */
    public function allParticipants(): HasMany {
        return $this->hasMany(Participant::class)->withOutGlobalScopes();
    }


    /**
     * @return HasMany|Message|Collection
     */
    public function messages(): HasMany {
        return $this->hasMany(Message::class);
    }

    /**
     * @return HasMany|Message|Collection
     */
    public function attachments(): HasManyThrough {
        return $this->hasManyThrough(Attachment::class, Message::class)->whereNotIn('message_type', ['text', 'notify', 'location'])->orderBy('id','desc');
    }

    /**
     * @return HasMany|Message|Collection
     */
    public function readMessages(): HasMany {
        return $this->hasMany(SeenMessage::class)
        ->whereSeenBy(auth()->user()->id)->whereNotNull('seen_at');
    }

    /**
     * @return HasOne
     */
    public function latestMessage(): HasOne {
        return $this->hasOne(Message::class)->latestOfMany();
    }
    

    /**
     * @return HasOne
     */
    public function detail(): HasOne {
        return $this->hasOne(ThreadDetail::class);
    }

    public function chatActions()
    {
        return $this->morphMany(ChatAction::class, 'actionable');
    }

    /**
     * Returns an array of user ids that are associated with the thread.
     *
     * @param mixed $userId
     *
     * @return array
     */
    public function participantsUserIds($userId = null) {
        $users = $this->participants()->withTrashed()->select('user_id')->get()->map(function ($participant) {
            return $participant->user_id;
        });

        if ($userId !== null) {
            $users->push($userId);
        }

        return $users->toArray();
    }

    /**
     * Returns the user object that created the thread.
     *
     * @return null|Models::user()|\Illuminate\Database\Eloquent\Model
     */
    public function creator() {
        if ($this->creatorCache === null) {
            $firstMessage = $this->messages()->withTrashed()->oldest()->first();
            $this->creatorCache = $firstMessage ? $firstMessage->user : config('auth.providers.users.model');
        }

        return $this->creatorCache;
    }

    /**
     * Returns the title attribute for the thread.
     *
     * @return String|null
     */
    public function getTitleAttribute(): String {
        $profile = (new MyUser)->extractUserInfo($this->participant()->user);
        
        return  match ($this->thread_type) {
            'group' => $this->name,
            'one-to-one' => $profile['name'],
            default => ''
        };
    }
}
