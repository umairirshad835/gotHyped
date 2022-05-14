<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;

use App\Helpers\fireBaseNotification;


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

        $notification = [
            'title' => $request->title,
            'body' => $request->body,
            'status' => 1,
        ];

        $notification = Notification::create($notification);

        $checkTokens = User::where('roles', 'customer')->whereNotNull('device_token')->get();
        $body = $request->body;
        $title = $request->title;
        if(empty($title))
        {
            $app_title = "GotHyped";
        }
        else
        {
            $app_title = $title;
        }
        foreach($checkTokens as $token)
        {
            $appNotification = [
                "title" => $app_title,
                "body" => $body,
                "device_token" => $token->device_token,
            ];

            fireBaseNotification::sendAppNotification($appNotification);
        }

        if($notification)
        {
            return redirect()->route('notificationList')->with('success','Notification Generated Successfully');
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
