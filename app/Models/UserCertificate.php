<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCertificate extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'user_certificate';
    protected $guarded = [];

}
