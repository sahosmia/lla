<?php

namespace App\Models;

use App\Casts\WalletDetailCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserWalletDetail extends Model
{
    public $guarded = [];

    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => WalletDetailCast::class,
        ];
    }


    public function userWallet(): BelongsTo
    {
        return $this->belongsTo(UserWallet::class);
    }
}
