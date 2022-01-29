<?php

namespace App\Http\Controllers\AppControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class WebAuthController extends Controller
{
  public function login(){
    return view('app.login');
  }

  public function doLogin(Request $request){
    $credentials = $request->only('email', 'password');

    if (Auth::guard('web')->attempt($credentials, true)) {
       $request->session()->regenerate();
       return redirect()->intended('/cliente');
    }

    return redirect()->back()->with('mensaje', 'Error iniciando sesion.');

  }
}
