<?php

namespace Amentotech\LaraGuppy\Models;

use Amentotech\LaraGuppy\ConfigurationManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeenMessage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function __construct() {
        $this->table = config('laraguppy.db_prefix') . ConfigurationManager::SEEN_MESSAGES_TABLE;
        parent::__construct();
    }

    public function message(): BelongsTo 
    {
        return $this->belongsTo(Message::class);
    }
}
