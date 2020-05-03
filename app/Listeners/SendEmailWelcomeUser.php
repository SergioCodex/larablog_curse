<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailWelcomeUser
{

    private $event;

    /**
     * Handle the event.
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $data['title'] = "Bienvenido " . $event->user->name;

        $this->event = $event;

        Mail::send('emails.email', $data, function ($message) {
            $message->sender('larablog@laravel.com', 'Sergio');
            $message->to($this->event->user->email, $this->event->user->name);
            $message->subject('Gracias por todo');
        });
    }
}
