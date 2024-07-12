<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' =>'required|email|max:255',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)){
            session()->flash('success','歡迎回來');
            return redirect()->route('users.show',[Auth::user()]);
        }else{
                session()->flash('danger','很抱歉, 您的信箱與密碼不符合');
                return redirect()->back()->withInput($request->except('password'));
        }
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出!');
        return redirect('login');
    }
}
