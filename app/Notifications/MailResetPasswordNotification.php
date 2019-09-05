<?php

namespace LinkApp\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Messages\MailMessage;

class MailResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public $token;
  

    public static $toMailCallback;

    public function __construct($token)
    {
        $this->token = $token;
    
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
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }
        $user = $notifiable;

        return (new MailMessage)
            ->greeting(Lang::get(__('auth.Greeting')))
            ->subject(Lang::get(__('auth.ResetPasswordNotification')))
            ->line(Lang::get(_('auth.You are receiving this email because we received a password reset request for your account')))
            ->action(Lang::get('auth.ResetPassword'), url(config('app.url').route('password.reset', ['token' => $this->token, 'idUser' => $user->id], false)))
            ->line(Lang::get(_('auth.This password reset link will expire in :count minutes'), ['count' => config('auth.passwords.users.expire')]))
            ->line(Lang::get(_('auth.If you did not request a password reset, no further action is required')));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
