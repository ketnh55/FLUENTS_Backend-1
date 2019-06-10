<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;

class UpdateUserProfileMail extends Notification implements ShouldQueue
{
    use Queueable;

    protected $subject;
    protected $user;

    private $BASE_URL = 'https://fluents.app/profile';
    /**
     * UpdateUserProfileMail constructor.
     * @param $subject
     * @param User $user
     */
    public function __construct()
    {
        //
        $this->subject = __('mail_message.update_profile_title');
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
            ->greeting('Hi ' . $notifiable->username)
            ->line('A recent update was made to your FLUENTS profile. If you made this change, you don\'t need to do anything else.')
            ->line('If you didn\'t make this update, click the link below to reverse the change.')
            ->action(Lang::getFromJson('Update Profile link'), $this->BASE_URL)
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
