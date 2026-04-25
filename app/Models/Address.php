<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Address extends Model {
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'country_id',
        'state_id',
        'city',
        'zipcode',
        'address',
        'lat',
        'lang',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
    protected $with = ['country', 'state'];
    /**
     * Get the user associated with the Address
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function country(): HasOne {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function state(): HasOne {
        return $this->hasOne(CountryState::class, 'id', 'state_id');
    }

    public function getFullAddressAttribute() {
        return "$this->address $this->city $this->state->name , $this->country->short_code";
    }
}
