<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use Illuminate\Support\Facades\Lang;

class ActiveNotificationMail extends Notification implements ShouldQueue
{
    use Queueable;

    protected $token;
    protected $subject;
    protected $user;

    private $BASE_URL = 'https://fluents.app/register/check/';
    /**
     * RegisterNotificationMail constructor.
     * @param $token
     * @param $subject
     * @param User $user
     */
    public function __construct($token, $subject, User $user)
    {
        //
        $this->token = $token;
        $this->subject = $subject;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $link = $this->BASE_URL.$this->token;
        return (new MailMessage)
            ->subject(Lang::getFromJson($this->subject))
            ->from('contact@fluents.app', 'FLUENTS')
            ->greeting('Hi ' .$this->user->email)
            ->line(Lang::getFromJson('We received a request to active your FLUENTS account.'))
            ->action(Lang::getFromJson('Active'), $link)
            ->line(Lang::getFromJson('This active link will expire in :count minutes.', ['count' => config('auth.passwords.users.expire')]))
            ->line(Lang::getFromJson('If you ignore this message, your account will not be activated. If you didn\'t request a activation, let us know.'))
            ->line('contact@fluents.app');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
