<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Sale;
use App\Models\Sales;
use App\Models\Supplier;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class InvoiceController extends Controller
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


    public function index()
    {
        $invoices = Invoice::all();
        return view('invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        return view('invoice.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->product_id);
        $request->validate([
            'customer_name' => 'nullable|string',
            'customer_phone' => 'nullable|string',
            'product_id' => 'required|array',
            'qty' => 'required|array',
            'price' => 'required|array',
            'dis' => 'required|array',
            'amount' => 'required|array',
            'count' => 'required|array',
        ]);

        $invoice = new Invoice();
        $invoice->customer_name = $request->customer_name;
        $invoice->customer_phone = $request->customer_phone;
        $invoice->total = 0; // Initialize total to 0
        $invoice->save();

        $totalAmount = 0;

        foreach ($request->product_id as $key => $product_id) {
            $sale = new Sale();
            $sale->qty = $request->qty[$key];
            $sale->price = $request->price[$key];
            $sale->dis = $request->dis[$key];
            $sale->count = $request->count[$key];
            $sale->amount = $request->amount[$key];
            $sale->product_id = $product_id;
            $sale->invoice_id = $invoice->id;
            $sale->save();

            $totalAmount += $sale->amount; // Add the sale amount to the total
        }

        $invoice->total = $totalAmount; // Update the invoice total with the calculated amount
        $invoice->save(); // Save the updated invoice

        return redirect('invoice/' . $invoice->id)->with('message', 'Invoice created successfully');
    }




    public function findPrice(Request $request)
    {
        $data = DB::table('products')->select('sales_price','quantity','unit')->where('id', $request->id)->first();
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
        $invoice = Invoice::findOrFail($id);
        $sales = Sale::where('invoice_id', $id)->get();
        return view('invoice.show', compact('invoice', 'sales'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $products = Product::orderBy('id', 'DESC')->get();
        $invoice = Invoice::findOrFail($id);
        $sales = Sale::where('invoice_id', $id)->get();
        return view('invoice.edit', compact('products', 'invoice', 'sales'));
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
        $request->validate([
            'customer_name' => 'nullable|string',
            'customer_phone' => 'nullable|string',
            'product_id' => 'required|array',
            'qty' => 'required|array',
            'price' => 'required|array',
            'dis' => 'required|array',
            'amount' => 'required|array',
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->customer_name = $request->customer_name;
        $invoice->customer_phone = $request->customer_phone;
        $invoice->total = 0; // Initialize total to 0

        // Delete existing sales related to the invoice
        Sale::where('invoice_id', $invoice->id)->delete();

        $totalAmount = 0;

        foreach ($request->product_id as $key => $product_id) {
            $sale = new Sale();
            $sale->qty = $request->qty[$key];
            $sale->price = $request->price[$key];
            $sale->dis = $request->dis[$key];
            $sale->count = $request->count[$key];
            $sale->amount = $request->amount[$key];
            $sale->product_id = $product_id;
            $sale->invoice_id = $invoice->id;
            $sale->save();

            $totalAmount += $sale->amount; // Add the sale amount to the total
        }

        $invoice->total = $totalAmount; // Update the invoice total with the calculated amount
        $invoice->save(); // Save the updated invoice

        return redirect('invoice/' . $invoice->id)->with('message', 'Invoice updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        Sales::where('invoice_id', $id)->delete();
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return redirect()->back();
    }
}
