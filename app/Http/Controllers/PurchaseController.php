<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\Invoice;
use App\Models\PurchaseDetail;
use App\Models\PurchaseInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('auth');
    }


   public function index(Request $request)
    {
        $query = PurchaseInvoice::with('supplier');

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

        $purchases = $query->orderByDesc('created_at')->paginate(10);

        return view('purchase.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('purchase.create', compact('suppliers','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_name' => 'required',
            'supplier_phone' => 'required|numeric|digits_between:10,10',
            // 'place' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = $request->all();
        $supplier = null;
        if ($data['supplier_id']) {
            $supplier = Supplier::find($data['supplier_id']);
        } else {
            $supplier = Supplier::firstOrCreate([
                'name' => $data['supplier_name'] ?? "",
                'phone' => $data['supplier_phone'] ?? "",
                // 'place' => $data['place'] ?? "",
            ]);
        }

        $invoice =  PurchaseInvoice::create([
            'supplier_id' => $supplier->id,
            'total' => $request->total,
            'paid' => $request->paid ?? 0,
            'balance' => $request->balance ?? 0,
            'discount' => $request->discount ?? 0,
            'payment_method' => $request->payment_method,
            'purchase_invoice_no' => 1000 + rand(0, 99999),
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

            Purchase::create([
                // 'customer_id' => $supplier->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'amount' => $amount,
                'purchase_invoice_id' => $invoice->id
            ]);
        }

        return redirect()->route('purchase.index')->with('success', 'Purchase created successfully');
    }

    public function findPrice(Request $request){
        $data = DB::table('products')->select('sales_price')->where('id', $request->id)->first();
        return response()->json($data);
    }

    public function findPricePurchase(Request $request) {
        $data = DB::table('product_suppliers')
                ->select('price')
                ->where('product_id', $request->id)
                ->where('supplier_id', $request->supplier_id) // Assuming you pass supplier_id from the frontend
                ->first();

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = PurchaseInvoice::findOrFail($id);
        $purchase = Purchase::where('purchase_invoice_id', $id)->get();
        return view('purchase.show', compact('invoice','purchase'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $suppliers = Supplier::all();
        $products = Product::all();
        $purchase = PurchaseInvoice::findOrFail($id);
        return view('purchase.edit', compact('products','purchase','suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // Validate the request
        $validator = Validator::make($request->all(), [
            'supplier_name' => 'required',
            'supplier_phone' => 'required|numeric|digits_between:10,10',
            // 'place' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Retrieve the data from the request
        $data = $request->all();
        $supplier = null;

        // Find or create the supplier
        if ($data['supplier_id']) {
            $supplier = Supplier::find($data['supplier_id']);
            $supplier->name = $data['supplier_name'] ?? $supplier->name;
            $supplier->phone = $data['supplier_phone'] ?? $supplier->phone;
            // $supplier->place = $data['place'] ?? $supplier->place;
            $supplier->save();
        } else {
            $supplier = supplier::firstOrCreate([
                'name' => $data['supplier_name'] ?? "",
                'phone' => $data['supplier_phone'] ?? "",
                // 'place' => $data['place'] ?? "",
            ]);
        }

        // Find the invoice by ID and update it
        $invoice = PurchaseInvoice::find($id);
        $invoice->update([
            'supplier_id' => $supplier->id,
            'total' => $request->total,
            'paid' => $request->paid ?? 0,
            'balance' => $request->balance ?? 0,
            'discount' => $request->discount ?? 0,
            'payment_method' => $request->payment_method,
            'date' => $request->date
        ]);

        // Delete existing sales associated with this invoice
        Purchase::where('purchase_invoice_id', $invoice->id)->delete();

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

            Purchase::create([
                // 'supplier_id' => $supplier->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'amount' => $amount,
                'purchase_invoice_id' => $invoice->id
            ]);
        }

        return redirect()->route('purchase.index')->with('success', 'Purchase updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $invoice = PurchaseInvoice::findOrFail($id);
        $invoice->delete();
        return redirect()->back();

    }
}
