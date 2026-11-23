<?php
namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class CustomerController extends Controller
{
    public function index() { $customers = Customer::latest()->paginate(10); return view('customers.index',compact('customers')); }
    public function create() { return view('customers.create',['customer'=>new Customer]); }
    public function store(Request $request) { $data=$request->validate(['full_name'=>'required|string|max:255','email'=>'required|email|max:255|unique:customers,email','phone'=>'nullable|string|max:30']); Customer::create($data); return redirect()->route('customers.index')->with('success','Customer created.'); }
    public function edit(Customer $customer) { return view('customers.edit',compact('customer')); }
    public function update(Request $request, Customer $customer) { $data=$request->validate(['full_name'=>'required|string|max:255','email'=>['required','email','max:255',Rule::unique('customers')->ignore($customer->id)],'phone'=>'nullable|string|max:30']); $customer->update($data); return redirect()->route('customers.index')->with('success','Customer updated.'); }
    public function destroy(Customer $customer) { if($customer->sales()->exists()) return back()->with('error','Customer has sales history and cannot be deleted.'); $customer->delete(); return redirect()->route('customers.index')->with('success','Customer deleted.'); }
}
