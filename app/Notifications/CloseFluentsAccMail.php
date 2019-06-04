<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use Illuminate\Support\Facades\Lang;

class CloseFluentsAccMail extends Notification implements ShouldQueue
{
    use Queueable;

    protected $token;
    protected $subject;
    protected $user;

    private $BASE_URL = 'https://fluents.app/user/close/';
    /**
     * CloseFluentsAccMail constructor.
     * @param $token
     * @param $subject
     * @param User $user
     */
    public function __construct($token, User $user)
    {
        //
        $this->token = $token;
        $this->subject = __('mail_message.close_fluent_account_title');
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
            ->greeting('Hi ' .$this->user->username)
            ->line(Lang::getFromJson('You recently requested to close your FLUENTS account.'))
            ->line(Lang::getFromJson('If you didn’t make this request, you don\'t need to do anything else. Your account will not be closed.'))
            ->line(Lang::getFromJson('If you made this request, click the link below to close the account.'))
            ->action(Lang::getFromJson('Close account'), $link)
            ->line(Lang::getFromJson('This active link will expire in :count minutes.', ['count' => config('auth.passwords.users.expire')]));
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
