<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ResetPasswordRequest;
use App\Http\Requests\Client\SendResetLinkRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    public function sendResetLink(SendResetLinkRequest $request)
    {
        // التحقق من أن الإيميل موجود في قاعدة البيانات
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
        // إنشاء كود مكون من 5 أرقام فقط
        $token = rand(10000, 99999);
        // حفظه في جدول password_resets
        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => $token,
                'created_at' => now(),
            ]
        );

        // إرسال الإيميل يدويًا
        Mail::raw("Your password reset code is: {$token}", function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Password Reset Code');
        });

        return response()->json(['message' => 'Password reset code sent successfully.']);
    }


    // 2️⃣ التحقق من صلاحية التوكن (من اللينك)
    public function verifyToken(Request $request)
    {
        $request->validate(['token' => 'required']);
        $passwordReset = DB::table('password_resets')->where('token', $request->token)->first();

        if (!$passwordReset) {
            return response()->json(['message' => 'Invalid or expired token.'], 400);
        }

        return response()->json([
            'message' => 'Token is valid.',
            'email' => $passwordReset->email
        ]);
    }

    public function reset(ResetPasswordRequest $request)
    {
        $passwordReset = DB::table('password_resets')->where('token', $request->token)->first();

        if (!$passwordReset) {
            return response()->json(['message' => 'Invalid or expired code.'], 400);
        }
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->setRememberToken(Str::random(60));
        $user->save();
        // حذف الرمز بعد الاستخدام
        DB::table('password_resets')->where('email', $passwordReset->email)->delete();
        return response()->json(['message' => 'Password reset successfully.']);
    }
}
