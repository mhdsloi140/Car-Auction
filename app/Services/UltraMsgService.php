<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
class UltraMsgService
{
    ///'
    public function sendMessage($to, $message)
    {
        $url = env('ULTRAMSG_URL') . '/' . env('ULTRAMSG_INSTANCE_ID') . '/messages/chat';
        $response = Http::post(
            $url,
            [
                'token' => env('ULTRAMSG_TOKEN'),
                'to' => $to,
                'body' => $message,
            ]
        );
        return $response->json();
    }
}
