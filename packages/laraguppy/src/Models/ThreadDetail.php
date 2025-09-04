<?php

namespace Amentotech\LaraGuppy\Models;

use Amentotech\LaraGuppy\ConfigurationManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThreadDetail extends Model {
    use HasFactory, SoftDeletes;
    protected $table;

    protected $creatorCache;

    public $fillable = ['description', 'photo', 'allow_reply', 'group_status', 'created_at', 'updated_at'];

    public function __construct() {
        $this->table = config('laraguppy.db_prefix') . ConfigurationManager::THREAD_DETAILS_TABLE;
        parent::__construct();
    }
}
