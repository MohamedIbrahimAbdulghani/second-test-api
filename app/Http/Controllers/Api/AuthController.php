<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login', 'register']]);
    // }

public function login(Request $request)
{
    // نعمل عملية تحقق (Validation) على البيانات اللي جاية من المستخدم
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',     // لازم يكون فيه ايميل وصحيح التنسيق
        'password' => 'required|string|min:3', // لازم يكون فيه باسورد نصي وطوله لا يقل عن 6 حروف
    ]);

    // لو التحقق فشل بيرجع رسالة خطأ للمستخدم
    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
        // 422 معناها خطأ في البيانات المرسلة (Unprocessable Entity)
    }

    // ناخد بيانات المستخدم (الإيميل + الباسورد) عشان نعمل محاولة تسجيل دخول
    $credentials = $request->only('email', 'password');

    // نحاول نعمل تسجيل دخول باستخدام الـ JWT
    if (!$token = auth()->attempt($credentials)) {
        return response()->json(['error' => 'بيانات الدخول غير صحيحة'], 401);
        // 401 معناها Unauthorized (يعني مش مسموح تدخل)
    }

    // لو البيانات صحيحة، بيرجعلك التوكن (JWT) ومعاه شوية بيانات اضافية
    return response()->json([
        'access_token' => $token,                 // التوكن اللي هتستخدمه في الطلبات بعد كده
        'token_type' => 'bearer',                 // نوع التوكن (Bearer)
        'expires_in' => auth()->factory()->getTTL() * 60, // وقت انتهاء التوكن بالثواني
        'user' => auth()->user(),                 // بيانات المستخدم اللي سجل الدخول
    ]);
}


    public function register(Request $request)
    {
            $validator = Validator::make($request->all(), [
                'name'     => 'required|string|max:255',
                'email'    => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:3',
            ]);

            if($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
            ]);

            // اعمل login بعد التسجيل
            $token = Auth::guard('api')->login($user);

            return $this->respondWithToken($token);
    }


    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }
}
