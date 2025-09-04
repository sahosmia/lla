<?php

namespace Amentotech\LaraGuppy\Models;

use Amentotech\LaraGuppy\ConfigurationManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class GpUser extends Model
{
    use HasFactory;

    protected $table;

    protected $fillable = ['user_id', 'name' ,'email', 'phone', 'photo', 'created_at', 'updated_at', 'deleted_at'];


    public function __construct() {
        $this->table = config('laraguppy.db_prefix') . ConfigurationManager::GP_USERS_TABLE;
        parent::__construct();
    }

    public function getPhotoAttribute($value){
        if(!empty($value)){
            return Storage::url($value);
        }
        return $value;
    }

}
