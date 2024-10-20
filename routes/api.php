<?php

use App\Http\Middleware\ApiAuthenticate;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
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
    if($request->username=='' || $request->password=='' || $request->device_token==''){
        return response()->json(['message' => 'Username or password is required'], 422);
    }
    $credentials = $request->only('username', 'password');
    $deviceToken = $request->input('device_token');
    $user = User::where('username', $credentials['username'])->first();
    if ($user && $user->password === $credentials['password']) {
        if(!$user->status){
            return response()->json(['message' => 'User not activated'], 403);
        }
        if(!is_null($user->expiration) && Carbon::parse($user->expiration) < Carbon::now()) {
            return response()->json(['message' => 'User expired'], 403);
        }
        if(is_null($user->device_token) || true) {
            $user->device_token = $deviceToken;
            $user->save();
        }else {
            if ($user->device_token !== $deviceToken) {
                return response()->json(['message' => 'Device token mismatch'], 422);
            }
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        $user->is_online = true;
        $user->save();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    return response()->json(['message' => 'Username or password is incorrect'], 422);
});

Route::post('/logout', function (Request $request) {
    // 檢查用戶是否已經通過身份驗證
    if (Auth::check()) {
        // 獲取當前認證的用戶
        $user = Auth::user();

        // 撤銷當前用戶的所有 token
        $user->is_online = false;
        $user->save();
        $user->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully'], 201);
    }
    // 如果用戶沒有登入，返回錯誤信息
    return response()->json(['message' => 'User not logged in'], 401);
})->middleware('auth:sanctum')->withoutMiddleware(ApiAuthenticate::class);

Route::get('/get-user', function (Request $request) {
    if (Auth::check()) {
        $user = Auth::user();
        if($user->is_online){
            return response()->json((new UserResource($user)), 200);
        }
    }
    return response()->json(['message' => 'User not logged in'], 401);
})->middleware('auth:sanctum')->withoutMiddleware(ApiAuthenticate::class);
