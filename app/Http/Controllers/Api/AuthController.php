<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\support\Facades\Auth;
use Illuminate\support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use App\Mail\SendResetPasswordCode;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Mail;

use App\Models\User;
use App\Models\VerifyCode;
use App\Models\UserSetting;
use App\Models\UserProfileSetting;

class AuthController extends Controller
{
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users|max:50',
            'name' => 'required|max:50',
            'email' => 'required|unique:users',
            'phone' => 'required|max:13',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        if($validator->fails())
        {
            $error = $validator->errors();
            $response = [
                'status' => 0,
                'message' => 'Sign up Un-Successful',
                'error' => $error
            ];

            return response()->json($response);
        }

        $customer = [
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'roles' => 'customer',
            'status' => 1,
        ];

        if(!empty($customer))
        {
            $user = User::create($customer);
            
            if(!empty($user))
            {
                $userSetting = new UserSetting;

                $settingData = [
                    'user_id' => $user->id,
                    'push_notification' => 0,
                    'alerts' => 0,
                    'user_profile_visibility' => 0,
                ];

                $setting = $userSetting->create($settingData);

                $profileSetting = new UserProfileSetting;

                $profileData = [
                    'user_setting_id' => $setting->id,
                    'name' => 0,
                    'auction_played' => 0,
                    'auction_won' => 0,
                    'items_liked' => 0,
                    'items_won' => 0,
                ];
                $saveProfileSetting = $profileSetting->create($profileData);                

                $respoonse = [
                    'status' => 1,
                    'message' => 'User created Successfully',
                    'method' => $request->route()->getActionMethod(),
                    'data' => $user,
                ];
                return response()->json($respoonse);
            }
            else
            {
                $response = [
                    'status' => 0,
                    'method' => $request->route()->getActionMethod(),
                    'message' => 'User not Created',
                    'data' => (object) array(),
                ];

                return response()->json($response);
            }
        }
        else
        {
            $response = [
                'status' => 0,
                'method' => $request->route()->getActionMethod(),
                'message' => 'Sign up Un-Successful',
                'data' => (object) array(),
            ];

            return response()->json($response);
        }
    }

    public function customerLogin(Request $request){

        $validator = validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails())
        {
            $error = $validator->errors();
            $response = [
                'status' => 0,
                'message' => 'Enter Your Login Credentials',
                'error' => $error
            ];

            return response()->json($response);
        }

        $customer = User::where(['username'=> $request->username])->first();

        if(!empty($customer))
        {
            if($customer->status == 1)
            {
                $allowLogin = true;
            }

            if($allowLogin)
            {
			    if (!Hash::check($request->password, $customer->password))
                {
			        return response()->json(['message',' The provided password does not match our records']);
			    }
    
		        $accessToken = $customer->createToken('customer_access_token')->accessToken;
		        $response = [
                    'status' => 1,
                    'message' => 'Customer Login successfully',
                    'method' => $request->route()->getActionMethod(),
                    'access_token' => $accessToken,
                    
                ];
                return response()->json($response);
        	}
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'The provided credentials does not match our records.',
                'method' => $request->route()->getActionMethod(),
                'access_token' => '',
                
            ];
            return response()->json($response);
        }
    }

    public function forgotPassword(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required',
        ]);

        if($validator->fails())
        {
            $error = $validator->errors();
            $response = [
                'status' => 0,
                'message' => 'Enter Your Email',
                'error' => $error
            ];

            return response()->json($response);
        }

        $customer = User::where(['email'=> $request->email])->first();

        if($customer)
        {
            $code = rand(100000, 999999);
            
            $data = [
                'email' => $customer->email,
                'code' =>  'GH-'.$code,
            ];
            // dd($data);

            $check_verify = VerifyCode::where('email', $customer->email)->first();
            if(!empty($check_verify))
            {
                $check_verify->update($data);
                $verify = $check_verify;
            }
            else
            {
                $verify = VerifyCode::create($data);
            }

            $text = "Dear " . $customer->name. ", we have ";
            $text = '';
		    $text .= '<div class="Container otpflow">
                <div class="Container invoicetext" style="font-size: 12px; color: black;">
                    <strong style="color: #ffcd34;"></strong>
                    <p style="padding: 0px 10px; text-align: justify;">Dear ' . $customer->name. ',</p>
                </div>
                <div class="Container invoicetext" style="font-size: 12px; color: black;">
                    <strong style="color: #ffcd34;"></strong>
                    <p style="padding: 0px 10px;">You are receiving this email because we received a password reset request for your account, <a style="color: #5ba9dc;">'. $customer->email .'</a></p>
                </div>
                <div class="Container invoicetext" style="font-size: 12px; color: black;">
                    <strong style="color: #ffcd34;"></strong>
                    <p style="padding: 0px 10px;">Please reset your password by using this code <span style="color: #5ba9dc; font-size: 16px; font-weight: bold">'. $verify->code .' </span></p>
                </div>
                <div class="appdetail" style="width: 100%;">
                    <div class="Container invoicetext" style="font-size: 12px; color: black;padding: 10px 10px;">If you do not wish to reset your password, please disregard this message.</div>
                </div>
                <div class="Container invoicetext" style="font-size: 12px; color: black;">
                    <strong style="color: #ffcd34;"></strong>
                    <p style="padding: 0px 10px; text-align: justify; font-weight: bold; font-size: 12px; color: black;">Hope this helps!</p>
                </div>
                <div class="Container invoicetext" style="font-size: 12px; color: black;">
                    <strong style="color: #ffcd34;"></strong>
                    <p style="padding: 0px 10px; text-align: justify; font-size: 12px; color: black;">Best Regards</p>
                    <p style="padding: 0px 10px; text-align: justify; font-size: 12px; color: black;">Team Got Hyped</p>
                </div>
            </div>';
            // require base_path("vendor/autoload.php");

            $mail = new PHPMailer(true);
            $mail->IsSMTP();  
            $mail->SMTPAuth = true;    
            $mail->SMTPSecure = "ssl";
            $mail->Host = "mail.gothyped.com";
            $mail->Port = 465;
            $mail->Username = "info@gothyped.com"; 
            $mail->Password = "Glen@420!";

            $mail->setfrom("info@gothyped.com", 'Got Hyped OTP');

            $mail->IsHTML(true);
            $mail->Subject = "OTP Password";
            $mail->Body    = $text;
            $mail->AddAddress($customer->email);
            if ($mail->Send()) {

                $response = [
                    'status' => 1,
                    'message' => 'OPT code send to your email, check your email box, or your spam as well.',
                    'method' => $request->route()->getActionMethod(),
                    'data' =>   $verify,
                    'email_response' => true,
                ];
                return response()->json($response);

            } else {
                $response = [
                    'status' => 0,
                    'message' => 'OPT code not sent to your email',
                    'method' => $request->route()->getActionMethod(),
                    'data' =>   $verify,
                    'email_response' => 'false'.$mail->ErrorInfo,
                ];
                return response()->json($response);
            }
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'E-mail does not match Our records please check your email',
                'method' => $request->route()->getActionMethod(),
                'data' => (object) array(),
                'email_response' => 'false',
            ];
            return response()->json($response);
        }
    }

    public function verifyOTP(Request $request)
    {
        $email = $request->email;
        $find_user = User::where('email',$email)->first();

        $validator = Validator::make($request->all(),[
            'code' => 'required',
            'email' => 'required',
        ]);

        if($validator->fails())
        {
            $error = $validator->errors();
            $response = [
                'status' => 0,
                'message' => 'Enter OPT Code.',
                'error' =>   $error,
            ];
            return response()->json($response);
        }
        $code = 'GH-'.$request->code;
        $code_verify = VerifyCode::where(['code'=> $code, 'email' =>$find_user->email])->first();

        if($code_verify)
        {
            $response = [
                'status' => 1,
                'message' => 'OTP verify Successfully.',
                'method' => $request->route()->getActionMethod(),
                'data' =>   $code_verify,
            ];
            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'The code you entered is not Correct.',
                'method' => $request->route()->getActionMethod(),
                'data' =>   (object) array(),
            ];
            return response()->json($response);
        }
    }

    public function resetPassword(Request $request){

        $email = $request->email;

        $validator = Validator::make ($request->all(), [
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        if($validator->fails())
        {
            $error = $validator->errors();
            $response = [
                'status' => 0,
                'message' => 'Please Enter password',
                'error' => $error
            ];
            return response()->json($response);
        }
            $update_data = [
                'password' => bcrypt($request->password),
            ];

            $update_password = User::where('email',$email)->update($update_data);

        if($update_password)
        {
            $response = [
                'status' => 1,
                'message' => 'Password Updated.',
                'method' => $request->route()->getActionMethod(),
                'data' =>   $update_password,
            ];
            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'please verify your email first.',
                'method' => $request->route()->getActionMethod(),
                'data' =>   (object) array(),
            ];
            return response()->json($response);
        }
    }

    public function updateProfile(Request $request){

        $validator = Validator::make ($request->all(), [
            // 'username' => 'required',
            // 'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'same:password'
        ]);

        if($validator->fails())
        {
            $error = $validator->errors();
            $response = [
                'status' => 0,
                'message' => 'Check Your Credentials',
                'error' => $error
            ];
            return response()->json($response);
        }

        $user = Auth::user();
	    $userId = $user->id;
        $find_user = User::find($userId);
        // dd($find_user);
        $data = [
            // 'username' => $request->username,
            // 'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => bcrypt($request->password),
        ];

        if(!empty($data))
        {
            $updateUser = $find_user->update($data);
            
            $response = [
                'status' => 1,
                'message' => 'Profile Updated.',
                'method' => $request->route()->getActionMethod(),
                'data' =>   $updateUser,
            ];

            return response()->json($response);
        }
        else
        {
            $response = [
                'status' => 0,
                'message' => 'Profile not Updated',
                'method' => $request->route()->getActionMethod(),
                'data' =>   (object) array(),
            ];

            return response()->json($response);
        }
    }
}
