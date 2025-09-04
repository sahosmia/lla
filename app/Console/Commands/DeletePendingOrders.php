<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class DeletePendingOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:delete-pending-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all pending orders from the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = Order::where('status', 0)->get();
        $deletedOrders = 0;

        foreach ($orders as $order) {
            $order->delete();
            $deletedOrders++;
        }
        $this->info("Deleted pending orders.");
    }
}
