<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
class StaffController extends Controller
{
    public function index() { $staff = User::latest()->paginate(10); return view('staff.index',compact('staff')); }
    public function create() { return view('staff.create',['member'=>new User]); }
    public function store(Request $request) { $data=$request->validate(['full_name'=>'required|string|max:255','name'=>'required|string|max:80|alpha_dash|unique:users,name','email'=>'required|email|max:255|unique:users,email','password'=>'required|string|min:8|confirmed','avatar'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048']); if($request->hasFile('avatar')) $data['avatar']=$request->file('avatar')->store('avatars','public'); User::create($data); return redirect()->route('staff.index')->with('success','Staff account created.'); }
    public function edit(User $staff) { return view('staff.edit',['member'=>$staff]); }
    public function update(Request $request, User $staff) { $data=$request->validate(['full_name'=>'required|string|max:255','name'=>['required','string','max:80','alpha_dash',Rule::unique('users')->ignore($staff->id)],'email'=>['required','email','max:255',Rule::unique('users')->ignore($staff->id)],'password'=>'nullable|string|min:8|confirmed','avatar'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048']); if(empty($data['password'])) unset($data['password']); if($request->hasFile('avatar')) { if($staff->avatar) Storage::disk('public')->delete($staff->avatar); $data['avatar']=$request->file('avatar')->store('avatars','public'); } $staff->update($data); return redirect()->route('staff.index')->with('success','Staff account updated.'); }
    public function destroy(User $staff) { if($staff->id===auth()->id()) return back()->with('error','You cannot delete your own account while signed in.'); if($staff->sales()->exists()) return back()->with('error','Staff member has sales history and cannot be deleted.'); if($staff->avatar) Storage::disk('public')->delete($staff->avatar); $staff->delete(); return redirect()->route('staff.index')->with('success','Staff account deleted.'); }
}
