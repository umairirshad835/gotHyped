<?php

namespace app\Helpers;
use Log;

class fireBaseNotification
{
    public static function sendAppNotification($data)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        // dd($data['device_token']);
        $token = $data['device_token'];
        $SERVER_API_KEY = env('FCM_SERVER_KEY');

        $fcmNotification = [
            'to' => $token,
            'data' => [
                'title' => $data['title'],
                'body' => $data['body'],
            ]
        ];

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
               
        $response = curl_exec($ch);
  
        if ($response === false) {
            die('Curl failed: ' . curl_error($ch));
        }

        curl_close($ch);

        log::info($response);

        return $response;
    }
}

?>