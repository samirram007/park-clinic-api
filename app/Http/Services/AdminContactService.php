<?php

namespace App\Http\Services;

use App\Http\Services\Contracts\AdminContactServiceInterface;
use App\Models\ContactMessage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AdminContactService implements AdminContactServiceInterface
{
    public function getPaginatedMessages(?int $perPage = 20, ?string $status = null, ?string $search = null): LengthAwarePaginator
    {
        $query = ContactMessage::query()->latest();

        if ($status) {
            if ($status === 'read') {
                $query->whereNotNull('read_at');
            } elseif ($status === 'unread') {
                $query->whereNull('read_at');
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

    public function deleteMessage(ContactMessage $contact): ?bool
    {
        return $contact->delete();
    }
}
