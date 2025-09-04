<?php

namespace Amentotech\LaraGuppy\Models;

use Amentotech\LaraGuppy\ConfigurationManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table;

    protected $casts = [
        'attachments' => 'array',
    ];

    protected $fillable = ['message_id', 'attachments', 'created_at', 'updated_at', 'deleted_at'];


    public function __construct() {
        $this->table = config('laraguppy.db_prefix') . ConfigurationManager::ATTACHMENTS_TABLE;
        parent::__construct();
    }

     /**
     * @return BelongsTo|Message
     */
    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }

    /**
     * @return BelongsTo|Thread
     */
    public function thread(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }
}
