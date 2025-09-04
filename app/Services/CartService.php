<?php

namespace App\Services;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
class CartService
{
    protected $userId;
    protected $items;

    public function __construct()
    {
        $this->userId = Auth::id();
        $this->items = Cache::rememberForever('cart_items_'.$this->userId, function () {
            return CartItem::where('user_id', $this->userId)->get();
        });
    }

    public function add($cartableId, $cartableType, $name, $qty, $price, $options = [], $discountAmount = 0)
    {
        $existingItem = $this->items->where('cartable_id', $cartableId)->where('cartable_type', $cartableType)->first();

        if ($existingItem) {
            return $existingItem;
        } else {
            $cartData = $this->prepareCartItem($cartableId, $cartableType, $name, $qty, $price, $options, $discountAmount);
            $item = CartItem::create($cartData);
            $this->reloadItems();

            return $item;
        }
    }

    protected function prepareCartItem($cartableId, $cartableType, $name, $qty, $price, $options, $discountAmount)
    {
        $cartData = [
            'cartable_id'=> $cartableId,
            'cartable_type'=> $cartableType,
            'user_id'   => $this->userId,
            'name'      => $name,
            'qty'       => $qty,
            'price'     => $price,
            'options'   => $options,
        ];
        if (\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal')) {
            if(!empty($discountAmount)){
                $cartData['discount_amount'] = $discountAmount;
            }
        }

        return $cartData;
    }

    public function remove($cartableId, $cartableType, $userId = null)
    {
        CartItem::where('user_id', $userId ?? $this->userId)
            ->where('cartable_id', $cartableId)
            ->where('cartable_type', $cartableType)
            ->delete();
        $this->reloadItems();
    }

    public function update($cartableId, $cartableType, $updatedCart = [])
    {
        CartItem::where('user_id', $this->userId)
            ->where('cartable_id', $cartableId)
            ->where('cartable_type', $cartableType)
            ->update($updatedCart);

        $this->reloadItems();
    }

    public function get($cartableId, $cartableType)
    {
        return CartItem::where('user_id', $this->userId)
            ->where('cartable_id', $cartableId)
            ->where('cartable_type', $cartableType)
            ->first();
    }

    public function getById($id)
    {
        return CartItem::whereKey($id)->first();
    }

    public function content()
    {
        return $this->items->map(function ($item) {
            $itemArray = $item->toArray();
            if (!empty($itemArray['options'])) {
                $itemArray['options']['price'] = formatAmount($itemArray['options']['price'], true);
                if (\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal') && !empty($itemArray['discount_amount'])) {
                    $itemArray['discounted_total'] = formatAmount(($itemArray['price'] - $itemArray['discount_amount']), true);
                }else{
                    $itemArray['discounted_total'] = '';
                }
            }
            return $itemArray;
        });
    }

    public function total()
    {
        if (\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal')) {
            $subtotal = $this->items->sum(function ($item) {
                return $item->qty * ($item->price - $item->discount_amount);
            });
        }else {
            $subtotal = $this->getSubtotal();
        }
        $tax = 0;
        $shipping = 0;
        return $subtotal + $tax + $shipping;
    }

    public function discount()
    {
        if (\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal')) {
            return $this->items->sum('discount_amount');
        }else {
            return 0;
        }
    }

    protected function getSubtotal()
    {
        return $this->items->sum(function ($item) {
            return $item->qty * $item->price;
        });
    }

    public function subtotal()
    {
        return $this->getSubtotal();
    }

    public function coupons()
    {
        return $this->items->map(function($item) {
            return $item->coupon;
        })->filter();
    }

    public function clear()
    {
        CartItem::where('user_id', $this->userId)->delete();
        $this->items = collect();
        Cache::forget('cart_items_'.$this->userId);
    }

    protected function reloadItems()
    {
        Cache::forget('cart_items_'.$this->userId);
        $this->items = Cache::rememberForever('cart_items_'.$this->userId, function () {
            return CartItem::where('user_id', $this->userId)->get();
        });
    }
}
