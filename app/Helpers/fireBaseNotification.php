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

        $fcmNotification = [
            'to' => $token,
            'data' => [
                'title' => $data['title'],
                'body' => $data['body'],
                'sound' => true,
            ]
        ];

        $headers = [
            "Authorization: key=AAAAecrVDhw:APA91bFIiaZkU5WyMo57V1AcUk3dbi7NIPASW5iRPvI_iyDTXQjx1K-HxQ3aeV3gCR4O0RQ_DPXazu3-sWEBj1ZSCrw6fC5-eN2rBCZyXDOLn6I4HwAfJDe5xw8FXSAt5jVM0zUOcegR",
            "Content-Type: application/json",
            "TTL: 600"
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