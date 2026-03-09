<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function admin()
    {
        return view('admin');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ],[
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',
            'password.required' => 'パスワードを入力してください',
        ]);

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => 'ログイン情報が登録されていません',
            ]);
        }

        $request->session()->regenerate();

        return redirect('/admin');
    }
}