<?php


namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Sale;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    // $sales = Sales::with('product')->get(); // Include products related to sales
    public function index(Request $request)
    {
        $query = Invoice::with('sale.product'); // Eager load sales and product relationships
    
        if ($request->filled('customer_name')) {
            $query->where('customer_name', 'like', '%' . $request->customer_name . '%');
        }
    
        if ($request->filled('customer_phone')) {
            $query->where('customer_phone', 'like', '%' . $request->customer_phone . '%');
        }
    
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }
    
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }
    
        $sales = $query->paginate(10);
        return view('sales.index', compact('sales'));
    }    
    
}
