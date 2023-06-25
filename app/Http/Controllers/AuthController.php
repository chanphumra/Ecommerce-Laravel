<?php

namespace App\Http\Controllers;

use App\Models\EmailOTP;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $image = "";

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extention = strtolower($file->getClientOriginalExtension());
            $image_name = time() . rand() . "." . $extention;
            $uploads_path = "uploads/user/";
            $image_url = "/" . $uploads_path . $image_name;
            $file->move($uploads_path, $image_name);
            $image = $image_url;
        }

        User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'image'         => $image,
            'role'          => $request->role,
            'verify'        => $request->verify
        ]);

        return response()->json(['message' => 'Register Successfully']);
    }

    public function login(Request $request)
    {
        $TOKEN_KEY = "051ecc732fcae9f5976a4549814f0db2199a244e4c70aef949090f237c8e24bd7648f4304296263a7811a3f5332fbdeb716fbee5e88af042843ff09704323308";

        $user = User::where([
            ['email', $request->email],
            ['role', $request->role]
        ])->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect email or password',
            ], 200);
        }

        $token = $user->createToken($TOKEN_KEY)->plainTextToken;
        return response()->json([
            "success" => true,
            "user" => $user,
            "token" => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout Successfull']);
    }

    public function exist(Request $request)
    {
        $user = User::where('email', $request->email)->get()->first();
        if ($user) return response()->json(["exist" => true], 200);
        return response()->json(["exist" => false], 200);
    }

    public function verify(Request $request)
    {
        $email = EmailOTP::where('email', $request->email)->get()->first();
        if ($email && $email->otp == $request->otp) {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $user->verify = 1;
                $user->save();
                $email->delete();
                return response()->json([
                    "success" => true,
                    "message" => "Your account has been verify"
                ], 200);
            }
        }
        return response()->json([
            'success' => false,
            "message" => "Incorrect OTP"
        ], 200);
    }

    public function updatePassword(Request $request, string $email){
        $user = User::where('email', $email)->get()->first();
        if($user){
            $user->password = Hash::make($request->newpassword);
            $user->save();

            return response()->json([
                'success' => true,
                "message" => "Update success"
            ], 200);
        }
    }
}
