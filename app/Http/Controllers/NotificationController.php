<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;


class NotificationController extends Controller
{
    public function notificationList(){
        $notificationList = Notification::paginate(25);
            return view('Admin.notification.index',compact('notificationList'));
    }

    public function addNotification(){
        return view('Admin.notification.add-notification');
    }

    public function saveNotification(Request $request){

        $request->validate([
            'title' => 'required|max:50',
            'body' => 'required|max:1000',
        ]);

        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
        $SERVER_API_KEY = env('FCM_SERVER_KEY');

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                'title' => $request->title,
                'body' => $request->body,
            ]
        ];

        $notification = [
            'title' => $request->title,
            'body' => $request->body,
            'status' => 1,
        ];

        // dd($data);

        $notification = Notification::create($notification);
        // dd($notification);
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
  
        // dd($response);

        if($notification)
        {
            return redirect()->route('notificationList')->with('success','Notification Added Successfully');
        }
    }

    public function editNotification($id){

        $notifincation = Notification::find($id);
            return view('Admin.notification.update-notification',compact('notifincation'));
    }

    public function updateNotification(Request $request){
        $request->validate([
            'title' => 'required|max:50',
            'body' => 'required|max:1000',
            'status' => 'required',
        ]);

        $update_notification =  Notification::find($request->notification_id);

        $data = [
            'title' => $request->title,
            'body' => $request->body,
            'status' => $request->status,
        ];

        $update_notification->update($data);
            return redirect()->route('notificationList')->with('success','Notification Updated Successfully');
    }

    public function changeNotificationStatus(Request $request, $id){
        $updateStatus = Notification::find($id);
        $status = [
            'status' => $request->status,
        ];
        
        $updateStatus->update($status);
        
            return redirect()->route('notificationList')->with('success','Notiication Status change Successfully');
    }
}
