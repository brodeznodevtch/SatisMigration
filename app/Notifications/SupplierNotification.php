<?php

namespace App\Notifications;

use Config;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupplierNotification extends Notification
{
    use Queueable;

    protected $notificationInfo;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notificationInfo)
    {
        $this->notificationInfo = $notificationInfo;
        $email_settings = $notificationInfo['email_settings'];
        $mail_driver = ! empty($email_settings['mail_driver']) ? $email_settings['mail_driver'] : 'smtp';

        Config::set('mail.driver', $mail_driver);
        Config::set('mail.host', $email_settings['mail_host']);
        Config::set('mail.port', $email_settings['mail_port']);
        Config::set('mail.username', $email_settings['mail_username']);
        Config::set('mail.password', $email_settings['mail_password']);
        Config::set('mail.encryption', $email_settings['mail_encryption']);

        Config::set('mail.from.address', $email_settings['mail_from_address']);
        Config::set('mail.from.name', $email_settings['mail_from_name']);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toMail($notifiable): MailMessage
    {
        $data = $this->notificationInfo;

        return (new MailMessage)
            ->subject($data['subject'])
            ->view(
                'emails.plain_html',
                ['content' => $data['email_body']]
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
