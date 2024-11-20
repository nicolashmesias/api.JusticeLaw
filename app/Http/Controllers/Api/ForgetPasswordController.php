<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;

class ForgetPasswordController extends Controller
{
    public function store(Request $request)
    {
$request->validate(['email' => ['required', 'email']]);

$status =Password::sendResetLink($request->only('email'));
   
if ($status === Password::RESET_LINK_SENT) {
    session()->flash('success', 'El código se ha enviado al correo');
    
}
return response()->json([
    'status' => $status === Password::RESET_LINK_SENT ? 'success' : 'error',
    'message' => __($status)
]);
}
}