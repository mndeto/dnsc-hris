<?php

namespace DNSCHumanResource\Listeners;

use DNSCHumanResource\Events\NotificationCreated as Event;
use DNSCHumanResource\Models\Notification;

class NotificationCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NotificationCreated  $event
     * @return void
     */
    public function handle(Event $event)
    {
        try {
            $notification = $event->notification;
            $cellphone_number = $notification->sent_to_user->employee->cellphone_number;

            if (!empty($cellphone_number) && $notification->sent_to_user->settings->notify_via_sms) {
                itexmo($cellphone_number, $notification->subject . ': ' . $notification->message);
            }
        } catch (\ErrorException $ex) {

        }
    }
}
