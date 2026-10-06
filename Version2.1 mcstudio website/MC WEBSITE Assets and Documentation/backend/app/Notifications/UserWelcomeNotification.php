<?php

namespace App\Notifications;

use App\Channels\SmsChannel;
use App\Concerns\CanSendSms;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserWelcomeNotification extends Notification
{
    use CanSendSms, Queueable;

    public $user;

    public $template;
    /**
     * Create a new notification instance.
     */
    public function __construct($user, $template)
    {
        $this->user     = $user;
        $this->template = $template;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'sms'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        $mail_template = EmailTemplate::where('record type', $this->template)->first();
        $link = URL::temporarySignedRoute(
            'filament.pages.login.token',
            now()->addMonths(3),
            ['user' => $this->user->id]
        );

        return (new MailMessage)
                    ->subject($mail_template->subject)
                    ->view('emails.user-welcome', [
                        'name'     => $this->user->name,
                        'email'    => $this->user->email,
                        'link'     => $this->prepareLink($link),
                        'template' => $mail_template->body
                    ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function prepareLink($link): mixed
    {
        $template = <<<EOL
        <div>
            <div class="py-4 my-4 text-center">
                <a href="$link" style="background-color:rgb(59,130,246);" class="bg-blue-500 text-white text-sm uppercase py-4 px-2 rounded-lg">click here to sign in to account</a>
            </div>
            <div class="text-sm py-4 my-4">
             If you are having trouble clicking the button, copy and paste the following link in your browser
             <p>{$link}</p>
            </div>
        </div>
        EOL;


        return $template;
    }
}
