<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Notifications\SendPushNotification;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Setting;
use App\Models\Event;
use App\Models\Job;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\Order;
use App\Models\DeleteAccount;


use Illuminate\Validation\Rules\File;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Datatables;


class AdminController extends Controller
{
    public function dashboard() {

        return view('admin.dashboard');
    }

    public function testNotification(Request $request) {

        $title     = "Side Hustle Test Notification";
        $message   = "Side Hustle Test Message";
        $fcmTokens = [0 => $request->fcmToken];
        Notification::send(null,new SendPushNotification($title,$message, $fcmTokens));
        
    }

    public function updateToken(Request $request){
        try{
            $request->user()->update(['fcm_token'=>$request->token]);
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }

    public function login(Request $request) {
        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'email'    => 'required|email',
                'password' => 'required'
            ]);
            if ($validator->fails()){
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            $user = User::where('email', $request->input('email'))->first();
            if ($user != null){
                if (Hash::check($request->input('password'), $user->password)) {
                    Auth::login($user);
                    if($user->role_id != 1) {
                        return redirect(route('admin.userDashboard'));
                    } else {
                        return redirect(route('admin.dashboard'));
                    }
                } else {
                    return back()->withErrors(['password' => 'invalid email or password']);
                }
            }else{
                return back()->withErrors(['password' => 'invalid email or password']);
            }
        }
        return view('admin.login');
    }
    public function changePassword()
    {
        return view('admin.change_password');
    }

    public function updateAdminPassword(Request $request)
    {
        $id = Auth::user()->id;

        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (Hash::check($request->current_password, Auth::User()->password)) {
            $content = User::find($id);
            $content->password = Hash::make($request->password);
            $content->save();
            return redirect()->back()->with('success', 'Password Update Successfully.');
        }else{
            return back()->withErrors(['current_password' => 'Your current Password not recognized']);
        }

    }
}
