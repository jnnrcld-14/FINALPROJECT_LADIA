<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\User;
class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'products' => Product::count(), 'customers' => Customer::count(),
            'salesCount' => Sale::count(), 'staffCount' => User::count(),
            'recentSales' => Sale::with(['product','customer','staff'])->latest()->take(8)->get(),
            'lowStock' => Product::where('stock_quantity','<=',5)->orderBy('stock_quantity')->take(8)->get()
        ]);
    }
}
