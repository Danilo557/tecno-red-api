<?php

namespace App\Services;

use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceService
{
    public function all()
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => InvoiceResource::collection(
                Invoice::included()
                    ->filter()
                    ->sort()
                    ->getOrPaginate()
            ),
        ], 200);
    }


    public function show($id)
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => InvoiceResource::make(Invoice::included()->findOrFail($id)),
        ], 200);
    }


    public function store(Request $request)
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => InvoiceResource::make(Invoice::create($request->all()))
        ], 200);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $invoice->update($request->all());
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' =>  InvoiceResource::make($invoice),
        ], 200);
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => InvoiceResource::make($invoice),
        ], 200);
    }

    public function delete_invoices_products($invoice, $product)
    {
        $invoice_item = Invoice::find($invoice);
        $invoice_item->products()->detach($product);
        $invoice_item->save();
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => InvoiceResource::make($invoice_item),
        ], 200);
    }

    public function add_invoices_products(Request $request)
    {
        $invoice_item = Invoice::find($request->invoice_id);
        $invoice_item->products()->attach([$request->product_id => $request->all()]);
        $invoice_item->save();
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => InvoiceResource::make($invoice_item),
        ], 200);
    }

    public function edit_invoices_products(Request $request)
    {
        $invoice_item = Invoice::find($request->invoice_id);
        $products = $invoice_item->products;

        foreach ($products as $product) {
            if ($product->id == $request->product_id) {
                $product->pivot->invoice_id = $request->invoice_id;
                $product->pivot->product_id = $request->product_id;
                $product->pivot->quantity = $request->quantity;
                $product->pivot->amount = $request->amount;
            }
        }

        $pivot = [];
        foreach ($products as $product) {
            $pivot[$product->id] = [
                "invoice_id" => $product->pivot->invoice_id,
                "product_id" => $product->pivot->product_id,
                "quantity" => $product->pivot->quantity,
                "amount" => $product->pivot->amount,
            ];
        }


        $invoice_item->products()->sync($pivot);

        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' =>  InvoiceResource::make($invoice_item),
        ], 200);
    }

    //edit_invoices_products
}
