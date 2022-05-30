<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class StaffController extends Controller
{
    public function staffList()
    {
        $staffList = User::whereIn('roles',['admin','manager','user'])->paginate(25);
        
            return view('Admin.Staff.index',compact('staffList'));
    }

    public function addStaff()
    {
        return view('Admin.Staff.add-staff');
    }

    public function saveStaff(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|unique:users',
            'phone' => 'required|max:13',
            'address' => 'required|max:100',
            'password' => 'required|min:8',
            'role' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'roles' => $request->role,
        ];

        $user = User::create($data);
        if($user){
            return redirect()->route('staffList')->with('success','User Save Successfully');
        }   
    }

    public function editStaff($id)
    {
        $staff = User::find($id);
            return view('Admin.Staff.update-staff',compact('staff'));
    }

    public function updateStaff(Request $request)
    {
        $request->validate([
            'name' => 'max:50',
            'email' => 'required',
            'phone' => 'max:13',
            'address' => 'max:100',
        ]);

        $id = $request->staff_id;
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $phone = $request->phone;
        $address = $request->address;
        $role = $request->role;

        $find_staff = User::find($id);

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'phone' => $phone,
            'address' => $address,
            'roles' => $role,
        ];

        $find_staff->update($data);
            return redirect()->route('staffList')->with('success','User Updated Successfully');
    }

    public function changeStaffStatus(Request $request, $id)
    {
        $updateStatus = User::find($id);
        $status = [
            'status' => $request->user_status,
        ];
        
        $updateStatus->update($status);
            return redirect()->back()->with('success','User Status change Successfully');
    }

}
