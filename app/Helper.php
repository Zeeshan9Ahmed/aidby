<?php

use App\Models\Notification;

function in_app_notification($data) {
    $notification = new Notification;
    $notification->sender_id = $data['sender_id'];
    $notification->receiver_id = $data['receiver_id'];
    $notification->title = $data['title'];
    $notification->description = $data['description'];
    $notification->record_id = $data['record_id'];
    $notification->record_id = $data['record_id'];
    $notification->type = $data['type'];
    $notification->save();
}