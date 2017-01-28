<?php

namespace LabEquipment\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MyOwnResetPassword extends Notification
{
    use Queueable;
    private $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->token = bcrypt(date('Y/m/d H:i:s'));
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
            ->view('notifications::myNotificationView')
            ->line('Password reset email:')
            ->action('RESET YOUR PASSWORD', url('/password/reset', $this->token))
            ->line('Password Reset')
            ->line('If you’ve lost your password or wish to reset it, use the link below to get started.')
            ->line('If you did not request a password reset, you can safely ignore this email. Only a person with access to your email can reset your account password.');
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
