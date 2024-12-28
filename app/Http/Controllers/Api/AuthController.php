<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;
use App\Models\UserLog;
use App\Models\Vendor;
use App\Models\Blog;

use Carbon\Carbon;
use Mail;

class AuthController extends Controller
{

    public function blogs() {
        $blogs = Blog::orderByDesc('id')->get();
        return $this->success($blogs);
    }
    public function login(Request $request){
        $this->requestValidate($request, [
            'email'    => 'required', //|regex:/(0)[0-9]{10}/
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        // dd($user);
        if ($user != null) {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
            } else {
                return $this->error("Invalid Credentials");
            }
        } else {
            return $this->error("Invalid Credentials");
        }

        $user->api_token =  auth()->user()->createToken('API Token')->plainTextToken;
        $user->save();
        return $this->success($user);
    }

    public function register(Request $request) {
        try {
           
            // $check_user = User::where('email', $request->email)->orWhere('phone', $request->phone)->first();
            $check_user = User::where('email', $request->email)->first();

            $validator = Validator::make($request->all(), [
                'user_type' => 'required',
                'phone'     => 'required',
                'email'     => 'required',
            ]);
            if ($validator->fails()){
                return $this->error('Validation Error', 200, [], $validator->errors());
            }
            if($check_user == null) {

                $digits   = 4;
                // $otpToken =  rand(pow(10, $digits-1), pow(10, $digits)-1);
                $otpToken =  1234;

                $user = User::create([
                    "role_id"    => $request->user_type,
                    "first_name" => $request->first_name,
                    "last_name"  => $request->last_name,
                    "name"      => $request->last_name.' '.$request->last_name,
                    "email"     => $request->email,
                    "phone"     => $request->phone,
                    "password"  => Hash::make("ahoyn@123"),
                    "otp"       => $otpToken,
                    "fcm_token" => $request->fcm_token ?? null,
                    "status"    => 0,
                ]);
                $token           = $user->createToken('API Token')->plainTextToken;
                $user->api_token = $token;
                $user->save();
                if($request->user_type == 2) {

                    $govt_id = "";
                    $business_license = "";
                    if ($request->has('govt_id')) {
            
                        $dir      = "uploads/news/";
                        $file     = $request->file('govt_id');
                        $fileName = time().'-service.'.$file->getClientOriginalExtension();
                        $file->move($dir, $fileName);
                        $fileName = $dir.$fileName;
                        $govt_id = asset($fileName);
                    }

                    if ($request->has('business_license')) {
            
                        $dir      = "uploads/news/";
                        $file     = $request->file('business_license');
                        $fileName = time().'-service.'.$file->getClientOriginalExtension();
                        $file->move($dir, $fileName);
                        $fileName = $dir.$fileName;
                        $business_license = asset($fileName);
                    }

                    Vendor::create([
                        "user_id"=>$user->id,
                        "business_name"=>$request->business_name,
                        "category"=>$request->category,
                        "address"=>$request->address,
                        "reg_number"=>$request->reg_number,
                        "govt_id"=>$govt_id,
                        "business_license"=>$business_license,
                        "bg_check_authorization"=>$request->bg_check_authorization
                    ]);
                }

                $mailData = array(
                    'otpCode'  => $otpToken,
                    'to'       => $user->email,
                );
        
                Mail::send('emails.otp', $mailData, function($message) use($mailData){
                    $message->to($mailData['to'])->subject('MobileApp - OTP Verification');
                });

                // $messageBody = env('APP_NAME')."\nOTP token is:$otpToken";
                // $this->sendMessageToClient($request->phone, $messageBody);
                return $this->success(array("otp" => $otpToken, "api_token" => $token,"user_id" => $user->id));
            } else {
                return $this->error('Email is already exist with service type '.$request->type, 200);
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function UpdateLocation(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'location'=> 'required',
                'lat'     => 'required',
                'lng'     => 'required',
            ]);
            if ($validator->fails()){
                return $this->error('Validation Error', 200, [], $validator->errors());
            }

            $user = User::find(auth()->user()->id);
            $user->location = $request->location;
            $user->lat      = $request->lat;
            $user->lng      = $request->lng;
            $user->save();

            return $this->success([], "Location updated");
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function resendOtpToken(Request $request) {
        $validator = Validator::make($request->all(), [
            'api_token' => 'required'
        ]);
        if ($validator->fails()){
            return $this->error('Validation Error', 429, [], $validator->errors());
        }

        $user = User::where("api_token", $request->api_token)->first();
        if ($user != null) {
            $digits = 4;
            $otpToken = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $otpToken =  1234;
            // $user->otp = $otpToken;
            $user->save();

            // try {
            //     $messageBody = env('APP_NAME') . "\nOTP token is:$otpToken";
            //     $this->sendMessageToClient($user->phone, $messageBody);
            // } catch (\Exception $ex) {
                //     return $this->error($ex->getMessage());
                // }
            return $this->success(array("otp" => $otpToken));
        } else { 
            return $this->error('Invalid User');
        }
    }

    public function verifyToken(Request $request) {
        $validator = Validator::make($request->all(), [
            'otp_token' => 'required',
            'api_token' => 'required'
        ]);
        if ($validator->fails()){
            return $this->error('Validation Error', 429, [], $validator->errors());
        }
        if ($request->has('otp_token')) {
            $user = User::where("api_token", $request->api_token)->first();
            if (isset($user->otp) && $user->otp == $request->otp_token) {
                $user->api_token = $user->createToken('API Token')->plainTextToken;
                $user->status    = 1;
                $user->save();
                Auth::login($user);
                return $this->success($user, 'Token Verified Successfully.');
            } else {
                return $this->error('Invalid OTP Token',422);
            }
        } else {
            return $this->error('OTP Token Required', 422);
        }
    }

    public function setPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'password'         => 'required',
            'confirm_password' => 'required',
            "user_id"          => 'required'
        ]);
        if ($validator->fails()){
            return $this->error('Validation Error', 429, [], $validator->errors());
        }

        $user            = User::find($request->user_id);
        $user->api_token = $user->createToken('API Token')->plainTextToken;
        $user->password  = Hash::make($request->password);
        $user->save();
        Auth::login($user);
        return $this->success($user, 'Password Set Successfully.');
    }

    public function updateFcmToken(Request $request){
        $validator = Validator::make($request->all(), [
            'fcm_token' => 'required'
        ]);
        if ($validator->fails()){
            return $this->error('Validation Error', 429, [], $validator->errors());
        }
        $user = Auth::user();
        $user->fcm_token = $request->fcm_token;
        $user->save();
        return $this->success($user, 'FCM Token Updated Successfully.');
    }

    public function logout(Request $request) {
        $user_id                  = Auth::user()->id;
        $update_status            = User::find($user_id);
        $update_status->is_active = 0;
        $update_status->save();

        Auth::user()->tokens()->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Successfully logged out'
        ]);
    }

    public function forgotPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);
        if ($validator->fails()){
            return $this->error('Validation Error', 429, [], $validator->errors());
        }

        $user = User::where('email', $request->email)->first();
        if ($user != null){

            $digits          = 4;
            // $otpToken        = rand(pow(10, $digits-1), pow(10, $digits)-1);
            $otpToken        = 1234;
            $user->api_token = $user->createToken('API Token')->plainTextToken;
            $user->otp       = (string)$otpToken;
            //$user->api_token = $user->createToken('API Token')->plainTextToken;
            $user->save();
            try {
                // $messageBody = env('APP_NAME')."\nOTP token is:$otpToken";
                // $this->sendMessageToClient($user->phone, $messageBody);

                $mailData = array(
                    'otpCode'  => $otpToken,
                    'to'       => $request->email,
                );
        
                Mail::send('emails.otp', $mailData, function($message) use($mailData){
                    $message->to($mailData['to'])->subject('MobileApp - OTP Verification');
                });

            } catch (\Exception $ex){
                return $this->error($ex->getMessage());
            }

            // $data = array('otp' => $user->otp, 'token' => $user->api_token);
            return $this->success($user, 'OTP has been sent on your phone.');
        }else{
            return $this->error('Your Phone is not registered. Please Signup', 429);
        }
    }

    // public function resetPassword(Request $request) {

    //     $validator = Validator::make($request->all(), [
    //         'password' => 'required|min:6',
    //     ]);
    //     if ($validator->fails()){
    //         return $this->error('Validation Error', 429, [], $validator->errors());
    //     }
       
    //     $user           = Auth::user();
    //     $user->password = Hash::make($request->password);
    //     $user->save();
    //     return $this->success([], 'Password Updated Successfully');

    // }

    public function changePassword(Request $request) {
        $validator = Validator::make($request->all(),[
            "old_password" => "required",
            "password"     => "required|min:6|confirmed",
        ]);
        if ($validator->fails()){
            return $this->error('Validation Error', 429, [], $validator->errors());
        }

        $user = Auth::user();

        if(Hash::check($request->old_password, $user->password)) {

            $user->password = Hash::make($request->password);
            $user->save();

            return $this->success([], 'Password Updated Successfully');

        } else {
            return $this->error("Please enter old password correctly..!!");
        }
    }

    public function unauthenticatedUser() {
        return $this->error('Unauthorized', 401);
    }

    public function sailor_services(Request $request) {

        $get_services         = SailorService::where('user_id',Auth::user()->id)->get();

        $sailor               = User::find(Auth::user()->id);
        $sailor->location     = $request->sailor_location;
        $sailor->latitude     = $request->sailor_lat;
        $sailor->longitude    = $request->sailor_lng;
        $sailor->referal_code = $request->referal_code;
        $sailor->save();

        $arr          = [];

        if(count($get_services) > 0) {

            foreach($get_services as $item) {
                array_push($arr, $item->service_id);
            }
            if ($request->service_id != null && !empty($request->service_id)) {
                for ($i = 0; $i < count($request->service_id); $i++) {
                    if (!in_array($request->service_id[$i], $arr)) {
                        $services = SailorService::create([
                            "user_id" => Auth::user()->id,
                            "service_id" => $request->service_id[$i],
                        ]);
                    }
                }
            }
        } else {
            if ($request->service_id != null && !empty($request->service_id)) {
                for ($i = 0; $i < count($request->service_id); $i++) {
                    $services = SailorService::create([
                        "user_id" => Auth::user()->id,
                        "service_id" => $request->service_id[$i],
                    ]);
                }
            }
        }
        $sailorServices         = SailorService::where('user_id',Auth::user()->id)->get();
        return $this->success($sailorServices, 'Services Added Successfully..!!');
    }

    public function is_active(Request $req) {

        $userid       = Auth::user()->id;
        $log          = new UserLog();
        $log->user_id = $userid;

        if($req->is_active == 1) {

            $log->start_datetime    = date('Y-m-d H:i:s');
            $log->save();

            $update_user            = User::find($userid);
            $update_user->is_active = 1;
            $update_user->save();

        } else {

            $update_log = UserLog::where('user_id', $userid)->orderBy('id','DESC')->first();
            $update_log->end_datetime = date('Y-m-d H:i:s');

            $startTime     = Carbon::parse($update_log->start_datetime);
            $endTime       = Carbon::parse($update_log->end_datetime);
            $totalDuration = $startTime->diff($endTime)->format('%H:%I:%S');

            $update_log->time_spent = $totalDuration;
            $update_log->save();

            $update_user            = User::find($userid);
            $update_user->is_active = 0;
            $update_user->save();
        }

        return $this->success([], 'Status Updated Successfully...!!');
    }
}
