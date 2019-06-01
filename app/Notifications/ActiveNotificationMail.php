<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Action;
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
        $this->subject = __('mail_message.active_mail_title');
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
            ->line(Lang::getFromJson('We received a request to activate your FLUENTS account.'))
            ->action(Lang::getFromJson('Activate'), $link)
            ->line(Lang::getFromJson('This activate link will expire in :count minutes.', ['count' => config('auth.passwords.users.expire')]))
            ->line(Lang::getFromJson('If you ignore this message, your account will not be activated. If you didn\'t request this activation, let us know.'))
            ->line($this->CONTACT_EMAIL);

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
