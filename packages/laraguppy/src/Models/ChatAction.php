<?php

namespace Amentotech\LaraGuppy\Models;

use Amentotech\LaraGuppy\ConfigurationManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatAction extends Model
{
    use HasFactory;

    protected $table;

    protected $fillable = ['user_id', 'actionable_id', 'actionable_type', 'action', 'created_at', 'updated_at'];

    public function __construct() 
    {
        $this->table = config('laraguppy.db_prefix') . ConfigurationManager::CHAT_ACTIONS_TABLE;
        parent::__construct();
    }

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    public function actionable()
    {
        return $this->morphTo();
    }
}
