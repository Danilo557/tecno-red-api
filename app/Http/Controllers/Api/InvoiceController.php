<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceProductRequest;
use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    private $service;

    public function __construct(InvoiceService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->all();
    }

    public function store(InvoiceRequest $request)
    {
        return $this->service->store($request);
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        return $this->service->update($request, $invoice);
    }

    public function destroy(Invoice $invoice)
    {
        return $this->service->destroy($invoice);
    }

    public function delete_invoices_products($invoice, $product)
    {
        return $this->service->delete_invoices_products($invoice, $product);
    }

    public function add_invoices_products(InvoiceProductRequest $request)
    {
        return $this->service->add_invoices_products($request);
    }

    public function edit_invoices_products(InvoiceProductRequest $request)
    {
        return $this->service->edit_invoices_products($request);
    }

     
}
