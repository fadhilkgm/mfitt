<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{

    public function index(Request $request)
    {
        $query = Invoice::with('customer');

        if ($request->has('customer_name')) {
            $query->whereHas('customer', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->customer_name . '%');
            });
        }

        if ($request->has('customer_phone')) {
            $query->whereHas('customer', function ($query) use ($request) {
                $query->where('phone', 'like', '%' . $request->customer_phone . '%');
            });
        }
        if ($request->has('date')) {
            $query->where('date', 'like', '%' . $request->date . '%');
        }
        if ($request->has('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $invoices = $query->orderByDesc('created_at')->get();

        return view('invoice.index', compact('invoices'));
    }
    public function create()
    {
        $products = Product::all();
        $customers = Customer::all();
        return view('invoice.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'customer_phone' => 'required|numeric|digits_between:10,10',
            'place' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = $request->all();
        $customer = null;
        if ($data['customer_id']) {
            $customer = Customer::find($data['customer_id']);
        } else {
            $customer = Customer::firstOrCreate([
                'name' => $data['customer_name'] ?? "",
                'phone' => $data['customer_phone'] ?? "",
                'place' => $data['place'] ?? "",
            ]);
        }

        $invoice =  Invoice::create([
            'customer_id' => $customer->id,
            'total' => $request->total,
            'paid' => $request->paid ?? 0,
            'balance' => $request->balance ?? 0,
            'discount' => $request->discount ?? 0,
            'payment_method' => $request->payment_method,
            'invoice_no' => 1000 + rand(0, 99999),
            'date' => $request->date
        ]);

        foreach ($data['product_name'] as $index => $productName) {
            $product = null;
            if (isset($data['product_id'][$index]) && $data['product_id'][$index]) {
                $product = Product::find($data['product_id'][$index]);
            } else {
                $product = Product::firstOrCreate(
                    [
                        'name' => $productName,
                    ],
                    [
                        'price' => $data['price'][$index],
                        'unit' => $data['unit'][$index]
                    ]
                );
            }

            $quantity = $data['quantity'][$index];
            $amount = $data['amount'][$index];

            Sale::create([
                'customer_id' => $customer->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'amount' => $amount,
                'invoice_id' => $invoice->id
            ]);
        }

        return redirect()->route('invoice.index')->with('success', 'Sale created successfully');
    }


    public function edit($id)
    {
        $invoice = Invoice::with(['customer', 'sales.product'])->findOrFail($id);
        $products = Product::all();
        $customers = Customer::all();
        return view('invoice.edit', compact('invoice', 'products', 'customers'));
    }

    public function update(Request $request, $id)
    {

        // Validate the request
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'customer_phone' => 'required|numeric|digits_between:10,10',
            'place' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Retrieve the data from the request
        $data = $request->all();
        $customer = null;

        // Find or create the customer
        if ($data['customer_id']) {
            $customer = Customer::find($data['customer_id']);
            $customer->name = $data['customer_name'] ?? $customer->name;
            $customer->phone = $data['customer_phone'] ?? $customer->phone;
            $customer->place = $data['place'] ?? $customer->place;
            $customer->save();
        } else {
            $customer = Customer::firstOrCreate([
                'name' => $data['customer_name'] ?? "",
                'phone' => $data['customer_phone'] ?? "",
                'place' => $data['place'] ?? "",
            ]);
        }

        // Find the invoice by ID and update it
        $invoice = Invoice::find($id);
        $invoice->update([
            'customer_id' => $customer->id,
            'total' => $request->total,
            'paid' => $request->paid ?? 0,
            'balance' => $request->balance ?? 0,
            'discount' => $request->discount ?? 0,
            'payment_method' => $request->payment_method,
            'date' => $request->date
        ]);

        // Delete existing sales associated with this invoice
        Sale::where('invoice_id', $invoice->id)->delete();

        // Create new sales records
        foreach ($data['product_name'] as $index => $productName) {
            $product = null;
            if (isset($data['product_id'][$index]) && $data['product_id'][$index]) {
                $product = Product::find($data['product_id'][$index]);
                $product->unit = $data['unit'][$index];
                $product->price = $data['price'][$index];
                $product->name = $data['product_name'][$index];
                $product->save();
            } else {
                $product = Product::firstOrCreate(
                    [
                        'name' => $productName,
                    ],
                    [
                        'price' => $data['price'][$index],
                        'unit' => $data['unit'][$index]
                    ]
                );
            }

            $quantity = $data['quantity'][$index];
            $amount = $data['amount'][$index];

            Sale::create([
                'customer_id' => $customer->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'amount' => $amount,
                'invoice_id' => $invoice->id
            ]);
        }

        return redirect()->route('invoice.index')->with('success', 'Invoice updated successfully');
    }



    public function show($id)
    {
        $invoice = Invoice::with(['customer', 'sales.product'])->findOrFail($id);
        $products = Product::all();
        $customers = Customer::all();
        // dd($invoice);
        return view('invoice.show', compact('invoice', 'products', 'customers'));
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return redirect()->route('invoice.index')->with('success', 'Invoice deleted successfully');
    }
}
