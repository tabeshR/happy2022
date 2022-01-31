<?php


namespace App\Notifications\Channels;


use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class SmsIr
{
    public function send($notifiable, Notification $notification)
    {

        if (!method_exists($notification, 'toSms')) {
            throw new \Exception('متد مورد نظر وجود ندارد');
        }
        try {
            $data = $notification->toSms($notifiable);
            $tokenResponse = Http::post('https://RestfulSms.com/api/Token', [
                "UserApiKey" => env('SMSIR_USER_API_KEY'),
                "SecretKey" => env('SMSIR_SECRET_KEY'),
            ]);

            $tokenKey = $tokenResponse->json()['TokenKey'];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-sms-ir-secure-token' => $tokenKey
            ])->post('https://RestfulSms.com/api/MessageSend', [
                "Messages" => [$data['text']],
                "MobileNumbers" => [$data['phone']],
                "LineNumber" => env('SMSIR_LINE_NUMBER'),
                "SendDateTime" => "",
                "CanContinueInCaseOfError" => "false"
            ]);
            return $response->json()['IsSuccessful'];
        } catch (\Exception $e) {
            throw new $e;
        }
    }
}
