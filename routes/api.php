<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', function (Request $request) {
    $credentials = $request->only('username', 'password');
    $deviceToken = $request->input('device_token');

    if (Auth::attempt(credentials: $credentials)) {
        $user = Auth::user();
        if(is_null($user->device_token)) {
            $user->device_token = $deviceToken;
            $user->save();

        }else {
            if ($user->device_token !== $deviceToken) {
                return response()->json(['message' => 'Device token mismatch'], 401);
            }
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    return response()->json(['message' => 'Username or password is incorrect'], 401);
});

Route::post('/logout', function (Request $request) {
    // 檢查用戶是否已經通過身份驗證
    if (Auth::check()) {
        // 獲取當前認證的用戶
        $user = Auth::user();

        // 撤銷當前用戶的所有 token
        $user->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    // 如果用戶沒有登入，返回錯誤信息
    return response()->json(['message' => 'User not logged in'], 401);
})->middleware('auth:sanctum');
