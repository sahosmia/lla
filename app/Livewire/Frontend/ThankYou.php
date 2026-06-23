<?php

namespace App\Livewire\Frontend;

use App\Models\OrderItem;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ThankYou extends Component
{
    public $orderId;

    public function mount($id)
    {
        $this->orderId = $id;
    }

    #[Layout('layouts.guest')]
    public function render()
    {

        $orderItem = OrderItem::where('order_id', $this->orderId)->get();
        if($orderItem->count() > 0){
            return view('livewire.frontend.thank-you', ['orderItem' => $orderItem]);
        }
        abort('404');
    }
}
