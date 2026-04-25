<?php

namespace App\Livewire\Pages\Admin\Invoices;

use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Invoices extends Component
{
    use WithPagination;

    public      $search             = '';
    public      $sortby             = 'desc';
    public      $status             = '';
    public      $subTotal;
    public      $discountAmount;
    public      $user;
    public      $company_name;
    public      $company_logo;
    public      $company_email;
    public      $company_address;
    private ?OrderService  $orderService        = null;
    public  $invoice;
    public function boot()
    {
        $this->user             = Auth::user();
        $this->orderService     = new OrderService();
    }

    public function mount()
    {
        $this->dispatch('initSelect2', target: '.am-select2' );
        $this->company_name      = setting('_general.company_name');
        $this->company_logo      = setting('_general.invoice_logo');
        $this->company_email     = setting('_general.company_email');
        $this->company_address   = setting('_general.company_address');
        $this->company_logo = !empty($this->company_logo[0]['path']) ? url(Storage::url($this->company_logo[0]['path'])) : asset('demo-content/logo-default.svg');
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        $orders = $this->orderService->getOrdersList($this->status, $this->search, $this->sortby);
        return view('livewire.pages.admin.invoices.invoices',compact('orders'));
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['status', 'search', 'sortby'])) {
            $this->resetPage();
        }
    }

    public function viewInvoice($id)
    {
        $this->invoice = $this->orderService->getOrdeWrWithItem($id, ['items', 'userProfile', 'countryDetails']);
        $this->dispatch('openInvoiceModal', id: 'invoicePreviewModal', action: 'show');
    }
}
