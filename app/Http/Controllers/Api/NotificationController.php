<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Notifications;


class NotificationController extends Controller
{
    public function is_notification(Request $request) {
        $validator  = Validator::make($request->all(), [
            "is_notify"       => 'required'
        ]);
        if ($validator->fails()){
            return $this->error('Validation Error', 200, [], $validator->errors());
        }

        $update_notify                       = User::find(Auth::user()->id);
        $update_notify->is_push_notification = $request->is_notify;
        $update_notify->save();

        return $this->success($update_notify, 'Status Update Successfully');
    }

    public function is_online(Request $request) {
        $validator  = Validator::make($request->all(), [
            "is_online"       => 'required'
        ]);
        if ($validator->fails()){
            return $this->error('Validation Error', 200, [], $validator->errors());
        }

        $update_notify            = User::find(Auth::user()->id);
        $update_notify->is_online = $request->is_online;
        $update_notify->save();

        return $this->success($update_notify, 'Status Updated Successfully');
    }

    public function notifications() {

        $userid        = Auth::user()->id;
        $notifications = Notifications::with('sender')->where('receiver_id', $userid)->orderByDESC('id')->get();

        if(count($notifications)) {
            foreach($notifications as $item) {
                $arr[] = [
                            "id"           => $item->id,
                            "sender_image" => $item->sender->image,
                            "sender_name"  => $item->sender->name,
                            "notification" => $item->notification,
                            "datetime"      => $item->created_at
                        ];
            }
            return $this->success($arr);
        } else {
            return $this->success($notifications);
        }
    }
}
