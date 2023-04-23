<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailOTP;

class MailController extends Controller
{

    public function sendEmail(Request $request) {
        
        if(!$request->receiver || !$request->otp){
            return response()->json([
                "message" => "receiver email and otp code are required"
            ],400);
        }

        if($this->isOnline()){
            $data = [
                'from'    => 'bazaar.shop.cambodia@gmail.com',
                'to'      => $request->receiver,
                'subject' => 'EMAIL VERIFYCATION',
                'otp'     => $request->otp,
            ];
            Mail::send('emailTemplate', $data, function ($message) use ($data) {
                $message->from($data['from'], 'Bazaar Shop Cambodia');
                $message->to($data['to'], 'you');
                $message->subject($data['subject']);
            });
            return response()->json([
                'success' => true,
                'message' => "Email was send"
            ],200);
        }

        return response()->json([
            'success' => false,
            'message' => "Please check your internet"
        ],200);
    }

    public function storeOTP(Request $request){
        if(!$request->email || !$request->otp) return response(['message' => 'email annd otp are require']);
        EmailOTP::create([
            'email' => $request->email,
            'otp' => $request->otp,
        ]);
    }

    public function deleteOTP(string $email)
    {
        $email = EmailOTP::where('email', $email)->get()->first();
        if($email) $email->delete();
    }

    public function isOnline() {
        if(@fopen('https://youtube.com/', 'r')){
            return true;
        }
        return false;
    }

    public function sendAdmin(Request $request) {
        
        if(!$request->sender || !$request->message){
            return response()->json([
                "message" => "receiver email and message are required"
            ],400);
        }

        if($this->isOnline()){
            $data = [
                'from'    => $request->sender,
                'to'      => 'bazaar.shop.cambodia@gmail.com',
                'subject' => 'CLIENT CONTACT',
                'msg' => $request->message,
            ];
            Mail::send('contactTemplate', $data, function ($message) use ($data) {
                $message->from($data['from'], 'you');
                $message->to($data['to'], 'Bazaar Shop Cambodia');
                $message->subject($data['subject']);
            });
            return response()->json([
                'success' => true,
                'message' => "Email was send"
            ],200);
        }

        return response()->json([
            'success' => false,
            'message' => "Please check your internet"
        ],200);
    }
}
