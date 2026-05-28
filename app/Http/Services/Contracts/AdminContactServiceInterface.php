<?php

namespace App\Http\Services\Contracts;

use App\Models\ContactMessage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AdminContactServiceInterface
{
    /**
     * Get paginated contact messages.
     *
     * @param int|null $perPage
     * @param string|null $status
     * @param string|null $search
     * @return LengthAwarePaginator
     */
    public function getPaginatedMessages(?int $perPage = 20, ?string $status = null, ?string $search = null): LengthAwarePaginator;

    /**
     * Mark message as read.
     *
     * @param ContactMessage $contact
     * @return ContactMessage
     */
    public function markAsRead(ContactMessage $contact): ContactMessage;

    /**
     * Mark message as unread.
     *
     * @param ContactMessage $contact
     * @return ContactMessage
     */
    public function markAsUnread(ContactMessage $contact): ContactMessage;

    /**
     * Toggle the importance status of a contact message.
     *
     * @param ContactMessage $contact
     * @return ContactMessage
     */
    public function toggleImportant(ContactMessage $contact): ContactMessage;

    /**
     * Reply to a contact message.
     *
     * @param ContactMessage $contact
     * @param string $message
     * @return ContactMessage
     */
    public function reply(ContactMessage $contact, string $message): ContactMessage;
}
