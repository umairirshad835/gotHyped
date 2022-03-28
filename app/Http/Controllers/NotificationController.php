<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;


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

        $data = [
            'title' => $request->title,
            'body' => $request->body,
        ];

        $notification = Notification::create($data);
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
