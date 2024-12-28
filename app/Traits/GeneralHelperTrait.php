<?php

namespace App\Traits;

use App\Models\User;
use App\Notifications\SendPushNotification;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Exception;
use Twilio\Rest\Client;


trait GeneralHelperTrait
{

    protected function sendMessageToClient($receiverNumber, $message){
        try {
            $account_sid  = env('TWILIO_ACCOUNT_SID');
            $auth_token   = env('TWILIO_AUTH_TOKEN');
            $twilio_number = env('TWILIO_PHONE_NUMBER');

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number,
                'body' => $message]);

            return array('success'=> true, 'message' => 'Message Sent Successfully');

        } catch (Exception $e) {
            return array('success'=> false, 'error' => $e->getMessage());
        }
    }


    protected function sendPushNotification($title, $message, $clickAction=null, $additionalData=null,
                                            $fcmTokens=array(), $userIds=array()) {
        try {
            if (empty($fcmTokens) && !empty($userIds)){
                $fcmTokens = User::whereIn('id', $userIds)->whereNotNull('fcm_token')
                    ->pluck('fcm_token')->toArray();
            }else if(empty($fcmTokens) && empty($userIds)){
                $fcmTokens = User::whereNotNull('fcm_token')
                    ->pluck('fcm_token')->toArray();
            }

            if (!empty($fcmTokens)){
                Notification::send(null, new SendPushNotification($title, $message, $clickAction, $fcmTokens, $additionalData));

                return array('success'=> true, 'message' => 'Notification Sent Successfully');
            }else{
                return array('success'=> false, 'message' => 'Firebase tokens not found');
            }

        } catch (Exception $ex) {
            return array('success'=> false, 'error' => $ex->getMessage());
        }
    }

}
