<?php

namespace Amentotech\LaraGuppy\Models;

use Amentotech\LaraGuppy\ConfigurationManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    
    protected $table;

    protected $fillable = ['message_id', 'notificationable_id', 'notificationable_type', 'notification_type', 'created_at', 'updated_at'];

    public function __construct() {
        $this->table = config('laraguppy.db_prefix') . ConfigurationManager::NOTIFICATIONS_TABLE;
        parent::__construct();
    }
}
