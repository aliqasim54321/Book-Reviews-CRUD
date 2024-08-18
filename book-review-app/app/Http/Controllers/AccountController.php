<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    //This method will show register page
    public function register(){
        return view('account.register');
    }

    //This method will register a user
    public function processRegister(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:5',
            'password_confirmation' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }

        //Now register User

        $user =new user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('account.login')-> with('success','You have register successfully.');
  }

  public function login(){
    return view('account.login');
  }
  
}
