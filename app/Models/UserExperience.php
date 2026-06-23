<?php

namespace App\Models;

use App\Casts\EmployementTypeCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExperience extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'user_experience';
    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'employment_type' => EmployementTypeCast::class,
        ];
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
