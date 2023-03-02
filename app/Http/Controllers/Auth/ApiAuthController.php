<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\OtpRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\VerificationRequest;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    public function register(RegistrationRequest $request)
    {
        $user = User::where('email', $request['email'])->first();
        if ($user) {
            return response(['status' => '400', 'message' => 'Bu email ile qeydiyyatdan kecilib'], 400);
        }
        try {
            $request['password'] = Hash::make($request['password']);
            $request['remember_token'] = Str::random(10);
            $response = $user = User::create($request->toArray());
            $token = $user->createToken('Registration')->accessToken;
            $response['token'] = $token;
            return response($response, 200);

        } catch (\Exception $e) {

            return response(["message" => 'Error', "status" => 400, "error" => $e], 400);
        }

    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request['email'])->whereNotNull('email_verified_at')->first();
        if ($user) {
            $user->deleteAccessTokens();
            if (Hash::check($request['password'], $user->password)) {
                $token = $user->createToken('Login')->accessToken;
                $response = ['token' => $token];
                return response(["data" => $user->toArray(), "token" => $response['token']], 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["status" => 410, "message" => 'Qeydiyyat tamamlanmayib'];
            return response($response, 410);
        }

    }

    public function otp(OtpRequest $request)
    {
        try {
            (new \App\Mail\EmailService)->sendOtp($request['email']);
            return response(['status' => '200', 'message' => 'ok'], 200);
        } catch (\Exception $e) {
            return response(['status' => '404', 'message' => 'error',], 404);
        }
    }

    public function verification(VerificationRequest $request)
    {

        $user = User::where('email', $request['email'])->first();
        $check = DB::table('accout_verify_code')->where('user_email', $request['email'])->orderBy('id', 'desc')->first();

        if ($check && $user) {
            if ($check->code == $request['code']) {
                $user['email_verified_at'] = date("Y-m-d");
                $user->save();
                $response = ["status" => 200, "message" => 'success'];
                return response($response, 200);
            } else {
                $response = ["status" => 404, "message" => 'Kod duz deyil'];
                return response($response, 404);
            }

        } else {
            $response = ["status" => 404, "message" => 'qeyd edilen e-mail movcud deyil'];
            return response($response, 404);
        }
    }

    public function asd(Request $request)
    {
        print_r($request->user());
        die();
    }

}
