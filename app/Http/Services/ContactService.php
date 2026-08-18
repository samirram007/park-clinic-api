<?php

namespace App\Http\Services;

use App\Http\Services\Contracts\ContactServiceInterface;
use App\Mail\ContactAcknowledgementMail;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use App\Traits\SendsMail;

class ContactService implements ContactServiceInterface
{
    use SendsMail;

    public function submit(array $data): ContactMessage
    {
        $message = ContactMessage::create($data);

        $this->sendMail(new ContactMessageMail($message), config('mail.contact_receiver'));
        $this->sendMail(new ContactAcknowledgementMail($message), $message->email);

        return $message;
    }

}
