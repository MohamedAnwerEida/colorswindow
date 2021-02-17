<?php

namespace App\Notifications;

//use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class PushDemo extends Notification {

    //  use Queueable;

    private $title = '';
    private $icon = '';
    private $body = '';
    private $action = '';

    public function __construct($title, $icon, $body, $action) {
        $this->title = $title;
        $this->icon = $icon;
        $this->body = $body;
        $this->action = $action;
    }

    public function via($notifiable) {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification) {
        return (new WebPushMessage)
                        ->title($this->title)
                        ->icon($this->icon)
                        ->body($this->body)
                        ->action($this->action, 'notification_action');
    }

}
