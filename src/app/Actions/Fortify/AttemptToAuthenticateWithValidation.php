<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;

class AttemptToAuthenticateWithValidation
{
    public function __invoke(Request $request, $next)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',
            'password.required' => 'パスワードを入力してください',
        ]);

        return $next($request);
    }
}