<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingDetail extends Model {

    use HasFactory;

    public $with = ['address'];

    public $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'company',
        'phone',
        'email',
        'created_at',
        'updated_at'
    ];

    public function address() {
        return $this->morphOne(Address::class, 'addressable');
    }
}
