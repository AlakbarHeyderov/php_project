<?php

namespace App\Mail;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function sendOtp($email)
    {
        $code = rand(100000, 999999);

        Mail::send([], [], function ($message) use ($email, $code) {
            $message->to($email)
                ->subject('Təsdiq nömrəsi')
                ->setBody('Sizin təsdiq kodunuz ' . $code, 'text/html'); // for HTML rich messages
        });
        DB::table('accout_verify_code')->insert(['code' => $code, 'user_email' => $email]);
    }

}

