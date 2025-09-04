<?php

namespace Amentotech\LaraGuppy\Models;

use Amentotech\LaraGuppy\ConfigurationManager;
use Amentotech\LaraGuppy\Models\Notification as GuppyNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model {
    use HasFactory, SoftDeletes;

    protected $table;

    protected $fillable = ['thread_id', 'messageable_id', 'messageable_type', 'body', 'chat_group_id', 'parent_message_id', 'message_type', 'created_at', 'updated_at', 'deleted_at'];

    protected $touches = ['thread'];

    protected static function booted() {
        static::created(function ($parentModel) {
            $parentModel->thread()->touch();
        });
    }

    public function __construct() {
        $this->table = config('laraguppy.db_prefix') . ConfigurationManager::MESSAGES_TABLE;
        parent::__construct();
    }

    /**
     * Get the user who sent that message
     */
    public function messageable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the thread containing that message
     */
    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * Get attachments of the message
     */
    public function attachments(): HasMany {
        return $this->hasMany(Attachment::class);
    }

    /**
     * Get parent message in case of a reply message
     */
    public function parentMessage(): BelongsTo{
        return $this->belongsTo(Message::class, 'parent_message_id', 'id');
    }

    /**
     * Get notification
     */
    public function notification(): HasOne
    {
        return $this->hasOne(GuppyNotification::class);
    }

    /**
     * Get message seen status
     */
    public function read(): HasOne
    {
        return $this->hasOne(SeenMessage::class)->whereNotNull('seen_at');
    }

    /**
     * Get message seen status
     */
    public function delivered(): HasOne
    {
        return $this->hasOne(SeenMessage::class);
    }

}
