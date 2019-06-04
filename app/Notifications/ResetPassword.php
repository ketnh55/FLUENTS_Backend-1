<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;
    protected $token;
    protected $subject;
    protected $user;

    private $BASE_URL = 'https://fluents.app/user/resetpwd/';
    private $CONTACT_EMAIL = 'contact@fluents.app';
    /**
     * RegisterNotificationMail constructor.
     * @param $token
     * @param $subject
     * @param User $user
     */
    public function __construct($token, User $user)
    {
        //
        $this->token = $token;
        $this->subject = __('mail_message.reset_password_mail_title');
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
                ->line(Lang::getFromJson('We received a request to reset your FLUENTS password.'))
                ->action(Lang::getFromJson('Reset Password'), $link)
                ->line(Lang::getFromJson('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.users.expire')]))
                ->line(Lang::getFromJson('If you ignore this message, your password will not be changed. If you didn\'t request a password reset, let us know.'))
                ->markdown('vendor.notifications.email', ['email' => $this->CONTACT_EMAIL]);

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
