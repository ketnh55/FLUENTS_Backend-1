<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class UpdateEmailMail extends Notification implements ShouldQueue
{
    use Queueable;
    protected $token;
    protected $subject;
    protected $user;

    private $BASE_URL = 'https://fluents.app/user/resetpwd/';
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
                ->greeting('Hi '.$this->user->username)
                ->from('contact@fluents.app', 'FLUENTS')
                ->line(Lang::getFromJson('The email :email for your FLUENTS account was recently changed. If you made this change, you don\'t need to do anything else.'
                    ,['email' => $this->user->email]))
                ->line(Lang::getFromJson('If you didn\'t make this change, click the link below to reset your password.'))
                ->action(Lang::getFromJson('Update email'), $link)
                ->line(Lang::getFromJson('This password reset link will expire in :count days.', ['count' => config('auth.passwords.users.expire')]));
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
