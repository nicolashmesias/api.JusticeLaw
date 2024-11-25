<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function sendResetCode(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users,email',
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => 'Invalid email address'], 400);
    }

    $user = User::where('email', $request->email)->first();
    $resetCode = Str::random(6);

    // Save the reset code to the database (or another persistent store)
    $user->reset_code = $resetCode;
    $user->save();

    // Send the email
    Mail::send([], [], function ($message) use ($user, $resetCode) {
        $message->to($user->email)
            ->subject('Password Reset Code')
            ->setBody("Your password reset code is: $resetCode");
    });

    return response()->json(['message' => 'Reset code sent'], 200);
}


public function resetPassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users,email',
        'code' => 'required|string',
        'password' => 'required|string|min:8|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => 'Invalid data'], 400);
    }

    $user = User::where('email', $request->email)
        ->where('reset_code', $request->code)
        ->first();

    if (!$user) {
        return response()->json(['message' => 'Invalid code'], 400);
    }

    $user->password = bcrypt($request->password);
    $user->reset_code = null;
    $user->save();

    return response()->json(['message' => 'Password reset successful'], 200);
}

}
