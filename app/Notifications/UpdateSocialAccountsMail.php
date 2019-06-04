<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;

class UpdateSocialAccountsMail extends Notification implements ShouldQueue
{
    use Queueable;

    protected $subject;
    protected $user;

    private $BASE_URL = 'https://fluents.app/profile';
    /**
     * RegisterNotificationMail constructor.
     * @param $subject
     * @param User $user
     */
    public function __construct(User $user)
    {
        //
        $this->subject = __('mail_message.update_social_account_title');
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
        $sns_type = '';
        if (Input::get('social_type') == 1) {
            $sns_type = 'Facebook';
        }
        if (Input::get('social_type') == 2) {
            $sns_type = 'Twitter';
        }
        if (Input::get('social_type') == 3) {
            $sns_type = 'Instagram';
        }
        if (Input::get('social_type') == 4) {
            $sns_type = 'Youtube';
        }
        return (new MailMessage)
            ->subject(Lang::getFromJson($this->subject))
            ->from('contact@fluents.app', 'FLUENTS')
            ->greeting('Hi ' . $this->user->username)
            ->line(Lang::getFromJson('Your :sns_type account :social_name linked to your FLUENTS account was recently updated. If you made this change, you don\'t need to do anything else. ', ['sns_type' => $sns_type, 'social_name' => Input::get('username')]))
            ->line(Lang::getFromJson('If you didn\'t make this change, click the link below to update the change.'))
            ->action(Lang::getFromJson('Update social account'), $this->BASE_URL);
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
