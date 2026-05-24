<?php
namespace App\Http\Services;

use App\Http\Services\Contracts\ContactServiceInterface;
use App\Mail\ContactAcknowledgementMail;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;

class ContactService implements ContactServiceInterface
{
    public function submit(array $data): ContactMessage
    {
        $message = ContactMessage::create($data);

        // Notify the clinic
        Mail::to(config('mail.contact_receiver'))
            ->send(new ContactMessageMail($message));

        // Acknowledge the user
        Mail::to($message->email)
            ->send(new ContactAcknowledgementMail($message));

        return $message;
    }

}
