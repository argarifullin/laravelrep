<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create()
    {
      return view('user.create');
    }

    public function store(Request $request)
    {
      $request->validate([
        'name'=>'required|unique:users',
        'email'=>'required|email|unique:users',
        'password'=>'required|confirmed',
      ]);

      $user=User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=> bcrypt($request->password),
      ]);
      session()->flash('success','Registration successful');
      Auth::login($user);
      return redirect()->home();
    }

    public function loginForm()
      {
        return view('user.login');
      }

    public function login (Request $request)
      {
        $request->validate([
          'email'=>'required|email',
          'password'=>'required',
        ]);
        if (Auth::attempt([
          'email'=>$request->email,
          'password'=>$request->password
        ])){
          session()->flash('success','login successful');
          if (Auth::user()->is_admin){
            return redirect()->route('admin.index');
          }
          return redirect()->home();
        }
        return redirect()->back()->with('error','incorrect login or password');
        }

    public function logout ()
      {
          Auth::logout();
          return redirect()->home();
      }

    public function index()
        {
        return view('restore.index');
        }

    public function restore(Request $request)
        {
        $request->validate([
           'email'=>'required|email|exists:users',
           'password'=>'required',
        ]);
        $email = $request->email;
        $password = bcrypt($request->password);
        $user = User::where('email',$email)->update(['password' => $password, 'is_admin' => 0]);

        return redirect()->route('login.create')->with('success', 'password was restored');
        }
}
