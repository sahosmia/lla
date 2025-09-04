<?php

namespace Amentotech\LaraGuppy\Models;

use Amentotech\LaraGuppy\ConfigurationManager;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class GuestAccount extends Authenticatable
{
    use HasFactory, HasApiTokens, SoftDeletes;

    protected $table;

    protected $guarded = [];


    public function __construct() {
        $this->table = config('laraguppy.db_prefix') . ConfigurationManager::GUEST_ACCOUNTS_TABLE;
        parent::__construct();
    }
}
