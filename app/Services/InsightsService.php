<?php

namespace App\Services;

use App\Casts\BookingStatus;
use App\Casts\OrderStatusCast;
use App\Casts\WalletDetailCast;
use App\Models\OrderItem;
use App\Models\SlotBooking;
use App\Models\User;
use App\Models\UserWalletDetail;
use Nwidart\Modules\Facades\Module;

class InsightsService
{

    public function getPlatformEarnings($revenueStartDate = null, $revenueEndDate = null)
    {
        if (!empty($revenueStartDate) && !empty($revenueEndDate)) {
            return OrderItem::whereHas('orders', function ($query) {
                return $query->whereStatus(OrderStatusCast::$statuses['complete'])->when(Module::has('subscriptions') && Module::isEnabled('subscriptions'), fn($query) => $query->whereNull('subscription_id'));
            })->whereBetween('created_at', [$revenueStartDate . ' 00:00:00', $revenueEndDate . ' 23:59:59'])->sum('total');
        }

        return OrderItem::whereHas('orders', function ($query) {
            return $query->whereStatus(OrderStatusCast::$statuses['complete'])->when(Module::has('subscriptions') && Module::isEnabled('subscriptions'), fn($query) => $query->whereNull('subscription_id'));
        })->sum('total');
    }

    public function getTutorEarnings($type, $revenueStartDate = null, $revenueEndDate = null)
    {
        if (!empty($revenueStartDate) && !empty($revenueEndDate)) {
            return UserWalletDetail::whereType(WalletDetailCast::$withdrawnTypes[$type])->whereBetween('created_at', [$revenueStartDate . ' 00:00:00', $revenueEndDate . ' 23:59:59'])->sum('amount');
        }

        return UserWalletDetail::whereType(WalletDetailCast::$withdrawnTypes[$type])->sum('amount');
    }

    public function getTutorPendingEarnings()
    {
        return UserWalletDetail::whereType('pending')->sum('amount');
    }

    public function getPlatformCommission($revenueStartDate = null, $revenueEndDate = null)
    {
        if (!empty($revenueStartDate) && !empty($revenueEndDate)) {
            return OrderItem::whereHas('orders', function ($query) {
                return $query->whereStatus(OrderStatusCast::$statuses['complete']);
            })->whereBetween('created_at', [$revenueStartDate . ' 00:00:00', $revenueEndDate . ' 23:59:59'])->sum('platform_fee');
        }

        return OrderItem::whereHas('orders', function ($query) {
            return $query->whereStatus(OrderStatusCast::$statuses['complete']);
        })->sum('platform_fee');
    }

    public function getSessions($statuses = [], $sessionStartDate = null, $sessionEndDate = null)
    {
        $statusValues = [];
        foreach ($statuses as $status) {
            if (isset(BookingStatus::$statuses[$status])) {
                $statusValues[] = BookingStatus::$statuses[$status];
            }
        }
        if (!empty($sessionStartDate) && !empty($sessionEndDate)) {
            return SlotBooking::whereBetween('start_time', [$sessionStartDate . ' 00:00:00', $sessionEndDate . ' 23:59:59'])->whereIn('status', $statusValues)->count();
        }
        return SlotBooking::whereIn('status', $statusValues)->count();
    }

    public function getUsers($roles = [], $dateRange = null)
    {
        $query = User::query();

        if (!empty($roles)) {
            $query->whereHas('roles', function ($query) use ($roles) {
                $query->whereIn('name', $roles);
            });
        }

        $query->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        });

        if ($dateRange === 'current_month') {
            $query->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year);
        } elseif ($dateRange === 'last_month') {
            $query->whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year);
        }

        return $query->get();
    }
}
