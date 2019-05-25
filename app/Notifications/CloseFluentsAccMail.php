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

    protected $link;
    protected $subject;
    protected $user;

    /**
     * CloseFluentsAccMail constructor.
     * @param $link
     * @param $subject
     * @param User $user
     */
    public function __construct($link, $subject, User $user)
    {
        //
        $this->link = $link;
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
        return (new MailMessage)
            ->subject(Lang::getFromJson($this->subject))
            ->from('contact@fluents.app', 'FLUENTS')
            ->greeting('Hi ' .$this->user->email)
            ->line(Lang::getFromJson('You recently requested to close your FLUENTS account.'))
            ->line(Lang::getFromJson('If you didn’t make this request, you don\'t need to do anything else. Your account will not be closed.'))
            ->line(Lang::getFromJson('If you made this request, click the link below to close the account.'))
            ->action(Lang::getFromJson('Close account'), $this->link)
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
