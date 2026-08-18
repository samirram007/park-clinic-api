<?php

namespace App\Traits;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

trait SendsMail
{
    /**
     * Send a mailable, either via the queue or synchronously, depending on the
     * `mail.queue` configuration.
     *
     * When the queue is enabled and a queue worker is running, mail is dispatched
     * asynchronously. Otherwise it is sent during the request lifecycle.
     *
     * @param  Mailable     $mail       The mailable instance to send.
     * @param  string|array $recipients One or more recipient email addresses.
     * @param  array        $context    Optional context data included in error logs.
     */
    protected function sendMail(Mailable $mail, string|array $recipients, array $context = []): void
    {
        $method = config('mail.queue') ? 'queue' : 'send';

        try {
            Mail::to($recipients)->{$method}($mail);
        } catch (\Throwable $e) {
            Log::error('Failed to send mail: '.$e->getMessage(), $context);
        }
    }
}
