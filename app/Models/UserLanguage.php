<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserLanguage extends Model {
    use HasFactory;

    /**
     * Get the user associated with the UserLanguage
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function language(): HasOne {
        return $this->hasOne(Language::class);
    }
}
