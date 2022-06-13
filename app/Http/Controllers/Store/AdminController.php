<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        return view('store.admin.index');
    }

    public function listAdmin(){
        $admins = User::all();
        return $admins;
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = New User;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password); 
        $admin->save();

        return $admin;
    }

    public function detail(Request $request)
    {
        $admin = User::where('id',$id)->first();
        return $admin;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required',
        ]);

        return User::find($id)->update($request->all());
    }

    public function destroy($id)
    {
       return User::find($id)->delete();
    }

}
