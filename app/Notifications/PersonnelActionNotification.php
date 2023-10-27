<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PersonnelActionNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $userFirstName;

    public $userLastName;

    public $type;

    public $employeeFirstName;

    public $employeeLastName;

    public function __construct($userFirstName, $userLastName, $type, $employeeFirstName, $employeeLastName)
    {
        $this->userFirstName = $userFirstName;
        $this->userLastName = $userLastName;
        $this->type = $type;
        $this->employeeFirstName = $employeeFirstName;
        $this->employeeLastName = $employeeLastName;
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
        return (new MailMessage)
            ->subject('Autorización - Acción de personal')
            ->greeting('Hola '.$this->userFirstName.' '.$this->userLastName.'')
            ->line('Se requiere de su autorización para la acción de personal '.$this->type.' para el empleado '.$this->employeeFirstName.' '.$this->employeeLastName.'.')
            ->line('Te invitamos a que ingreses al sistema')
            ->action('Iniciar sesión', url(config('app.url')));
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
