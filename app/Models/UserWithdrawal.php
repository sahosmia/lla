<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWithdrawal extends Model
{

    use HasFactory;


    protected $guarded = [];

    public $casts = [
        'detail' => 'array'
    ];

    /**
     * Get the user information.
     */
    public function User()
    {
        return $this->hasOneThrough(Profile::class, User::class, 'id', 'user_id', 'user_id', 'id');
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
