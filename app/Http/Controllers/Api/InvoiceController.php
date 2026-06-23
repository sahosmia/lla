<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Services\OrderService;
use App\Traits\ApiResponser;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    use ApiResponser;

    public function getInvoices(Request $request)
    {
        if (Auth::user()?->role  !== 'student') {
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $orderService     = new OrderService();
        $orders           = $orderService->getOrders($request->status, null, 'Desc', null , null ,Auth::user()->id);
        return $this->success(data: new OrderCollection($orders),message: __('api.invoices_retrieved_successfully'));
    }
}

