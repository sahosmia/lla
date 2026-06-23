<?php
namespace App\Services;

use App\Casts\WalletDetailCast;
use App\Models\UserWallet;
use App\Models\UserWalletDetail;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WalletService
{
    public function getUserWallet($userId)
    {
        return UserWallet::firstOrCreate(['user_id' => $userId]);
    }

    public function addFunds($userId, $amount, $orderId = null)
    {
        return DB::transaction(function () use ($userId, $amount, $orderId) {
            $wallet = $this->getUserWallet($userId);

            $wallet->update(['amount' => $wallet->amount + $amount]);

            $wallet->walletDetail()->create([
                'order_id' => $orderId,
                'amount'   => $amount,
                'type'     => 'add'
            ]);

            return $wallet;
        });
    }

    public function pendingAvailableFunds($userId, $amount, $orderId = null)
    {
        return DB::transaction(function () use ($userId, $amount, $orderId) {
            $wallet = $this->getUserWallet($userId);

            $wallet->walletDetail()->create([
                'order_id' => $orderId,
                'amount'   => $amount,
                'type'     => 'pending_available'
            ]);

            return $wallet;
        });
    }

    public function makePendingFundsAvailable($userId, $amount, $orderId = null)
    {
        
        return DB::transaction(function () use ($userId, $amount, $orderId) {
            $wallet = $this->getUserWallet($userId);
            $pendingAvailableFunds = $wallet->walletDetail()
                ->where('type', WalletDetailCast::$withdrawnTypes['pending_available'])
                ->where('order_id', $orderId)
                ->first();
            $pendingAvailableFunds->amount = $pendingAvailableFunds->amount - $amount;
            $pendingAvailableFunds->save();

            $wallet->walletDetail()->create([
                'order_id' => $orderId,
                'amount'   => $amount,
                'type'     => 'add'
            ]);

            $wallet->amount += $amount;
            $wallet->save();

            return $wallet;
            
        });
    }

    public function refundFromPendingFunds($userId, $amount, $orderId = null)
    {
        return DB::transaction(function () use ($userId, $amount, $orderId) {
            $wallet = $this->getUserWallet($userId);

            $pendingAvailableFunds = $wallet->walletDetail()
                ->where('type', WalletDetailCast::$withdrawnTypes['pending_available'])
                ->where('order_id', $orderId)
                ->first();
            $pendingAvailableFunds->amount = $pendingAvailableFunds->amount - $amount;
            $pendingAvailableFunds->save();

            $wallet->walletDetail()->create([
                'order_id' => $orderId,
                'amount'   => $amount,
                'type'     => 'deduct_refund'
            ]);

            return $wallet;
        });
    }


    public function deductFunds($userId, $amount, $type = 'add', $orderId = null)
    {
        return DB::transaction(function () use ($userId, $amount, $orderId, $type) {
            $wallet = $this->getUserWallet($userId);

            if ($wallet->amount < $amount) {
                Log::error('Insufficient funds', ['user_id' => $userId, 'amount' => $amount, 'wallet_amount' => $wallet->amount]);
            }

            $wallet->amount -= $amount;
            $wallet->save();

            $wallet->walletDetail()->create([
                'order_id' => $orderId,
                'amount'   => $amount,
                'type'     => $type
            ]);

            return $wallet;
        });
    }

    public function getWalletDetails($userWalletId)
    {

        return UserWalletDetail::where('user_wallet_id', $userWalletId)->get();
    }

    public function getEarnedIncome($userId)
    {
        return UserWallet::where('user_id', $userId)
            ->select('id')
            ->withSum(['walletDetail as earned_amount' => function($query) {
                $query->where('type', 1);
            }], 'amount')
            ->first()?->earned_amount ?? 0;
    }

    public function getPendingAvailableFunds($userId)
    {
        return UserWallet::where('user_id', $userId)
            ->select('id')
            ->withSum(['walletDetail as pending_available_amount' => function($query) {
                $query->where('type', 4);
            }], 'amount')
            ->first()?->pending_available_amount ?? 0;
    }

    public function getWalletAmount($userWalletId)
    {
        return UserWallet::where('user_id', $userWalletId)->select('amount')->first()?->amount ?? 0;
    }

    public function getUserEarnings($userId, $selectedDate)
    {
        $earnings = UserWalletDetail::select(DB::raw('SUM(amount) as total'), DB::raw('DAY(created_at) as day'))
            ->whereHas('userWallet', function($query) use ($userId) {
                $query->whereUserId($userId);
            })
            ->whereType(WalletDetailCast::$withdrawnTypes['add'])
            ->whereMonth('created_at', $selectedDate->format('m'))
            ->groupBy('day')
            ->pluck('total','day')
            ->toArray();

        $period         = CarbonPeriod::create($selectedDate->copy()->firstOfMonth(), $selectedDate->copy()->lastOfMonth());
        $earningsData = $days  = [];

        foreach($period as $date){
            $value = !empty($amounts[$date->day]) ? $earnings[$date->day] : 0;
            array_push($earningsData, $value);
            $days[$date->day] = $date->day;
        }

        return ['earnings' => $earnings, 'days' => $days];
    }
}
