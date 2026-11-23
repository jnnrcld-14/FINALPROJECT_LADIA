<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index() { $products = Product::latest()->paginate(10); return view('products.index', compact('products')); }
    public function create() { return view('products.create', ['product' => new Product]); }
    public function store(Request $request)
    {
        $data = $request->validate(['name'=>'required|string|max:255','price'=>'required|numeric|min:0.01','stock_quantity'=>'required|integer|min:0','image'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048']);
        if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('products','public');
        Product::create($data);
        return redirect()->route('products.index')->with('success','Product created.');
    }
    public function edit(Product $product) { return view('products.edit', compact('product')); }
    public function update(Request $request, Product $product)
    {
        $data = $request->validate(['name'=>'required|string|max:255','price'=>'required|numeric|min:0.01','stock_quantity'=>'required|integer|min:0','image'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048']);
        if ($request->hasFile('image')) { if ($product->image) Storage::disk('public')->delete($product->image); $data['image'] = $request->file('image')->store('products','public'); }
        $product->update($data);
        return redirect()->route('products.index')->with('success','Product updated.');
    }
    public function destroy(Product $product)
    {
        if ($product->sales()->exists()) return back()->with('error','This product has sales history and cannot be deleted.');
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();
        return redirect()->route('products.index')->with('success','Product deleted.');
    }
}
