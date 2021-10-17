<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\{LoginRequest, SignUpRequest, VerificationCodeRequest, LogoutRequest};
use App\Http\Resources\UserResource;
use App\Models\{Device, User};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //


    public function login(LoginRequest $request)
    {

        if (!$token = auth('api')->attempt(['phone' => $request->phone, 'password' => $request->password])) {
            return response()->json([
                'success' => false,
                'message' => 'تأكد من كتابه رقم الهاتف او الرقم السري',
            ], 400);
        }

        $user = auth('api')->user();

        $user->devices()->firstOrCreate($request->only('device_token'));


        data_set($user, 'token', $token);

        return response()->json([
            'status' => 'success',
            'message'  => '',
            'data' => new UserResource($user)
        ]);
    }

    public function register(SignUpRequest $request)
    {

        $code = rand(1000, 9999);

        $data = [
            'verification_code' => $code,
            'active' => '0',

        ];

        $user = User::create($request->validated() + $data);

        if (!$user) {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "لم يتم تسجيل حسابك "], 200);
        }

        return response()->json(['status' => 'success', 'data' => null, 'message' => "تم التسجيل بنجاح "], 400);
    }

    // confirm phone
    public function confirm(VerificationCodeRequest $request)
    {

        $user = User::where(['verification_code' => $request->code, 'phone' => $request->phone])->first();


        if (!$user) {
            return response()->json(['status' => 'fail', 'data' => null, 'message' => "الكود غير صحيح"], 400);
        }
        $user->update([
            'active' => '1',
            'verification_code' => null,
            'phone_verified_at' => Carbon::now()
        ]);
        $user->devices()->firstOrCreate($request->only(['device_token']));
        $token = auth('api')->login($user);


        data_set($user, 'token', $token);

        return response()->json(['status' => 'success', 'data' => new UserResource($user), 'message' => ""], 200);
    }
    public function logout(LogoutRequest $request)
    {
        if (auth('api')->check()) {
            $user = auth('api')->user();
            $device = Device::where(['user_id' => auth('api')->id(), 'device_token' => $request->device_token])->first();
            if ($device) {
                $device->delete();
            }

            auth('api')->logout();
            return response()->json(['status' => 'success', 'data' => null, 'message' => "تم تسجيل الخروج "],200);
        }
    }
}
