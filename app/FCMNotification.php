<?php

namespace App;

use LaravelFCM\Facades\FCM;
use App\User;
use LaravelFCM\Message\OptionsBuilder;
use Illuminate\Database\Eloquent\Model;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class FCMNotification extends Model
{
    public static function toSingleDeviceChat($token = null, $title = null, $body = null, User $user)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
            ->setSound('default');
        $notificationBuilder->setClickAction("OPEN_ACTIVITY_CHAT");


        $dataBuilder = new PayloadDataBuilder();



        $dataBuilder->addData([
            'title' => $title, 'message' => $body,
            'route' => 'Chat', 'name' => $user->name,
            'id' => $user->id
        ]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = $token;

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

        // return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

        // return Array (key : oldToken, value : new token - you must change the token in your database)
        $downstreamResponse->tokensToModify();

        // return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

        // return Array (key:token, value:error) - in production you should remove from your database the tokens
        $downstreamResponse->tokensWithError();
    }
}
