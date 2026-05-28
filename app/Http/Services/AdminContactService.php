<?php

namespace App\Http\Services;

use App\Http\Services\Contracts\AdminContactServiceInterface;
use App\Models\ContactMessage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Mail\ContactReplyMail;
use Illuminate\Support\Facades\Mail;

class AdminContactService implements AdminContactServiceInterface
{
    public function getPaginatedMessages(?int $perPage = 20, ?string $status = null, ?string $search = null, ?bool $isImportant = null): LengthAwarePaginator
    {
        $query = ContactMessage::query()->latest();

        if ($isImportant !== null && $isImportant === true) {
            $query->where('is_important', true);
        } else {
            if ($status) {
                if ($status === 'read') {
                    $query->whereNotNull('read_at');
                } elseif ($status === 'unread') {
                    $query->whereNull('read_at');
                }
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage ?? 20);
    }

    public function toggleImportant(ContactMessage $contact): ContactMessage
    {
        $contact->update(['is_important' => !$contact->is_important]);
        return $contact;
    }


    public function markAsRead(ContactMessage $contact): ContactMessage
    {
        $contact->update(['read_at' => now()]);
        return $contact;
    }

    public function markAsUnread(ContactMessage $contact): ContactMessage
    {
        $contact->update(['read_at' => null]);
        return $contact;
    }

    public function reply(ContactMessage $contact, string $message): ContactMessage
    {
        $contact->update([
            'reply_message' => $message,
            'reply_at' => now(),
        ]);

        Mail::to($contact->email)->send(new ContactReplyMail($contact));

        return $contact;
    }

    public function deleteMessage(ContactMessage $contact): ?bool
    {
        return $contact->delete();
    }
}
