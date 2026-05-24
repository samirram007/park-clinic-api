<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactMessageCollection;
use App\Http\Resources\ContactMessageResource;
use App\Http\Services\Contracts\AdminContactServiceInterface;
use App\Models\ContactMessage;




class ContactController extends Controller
{
    public function __construct(
        protected AdminContactServiceInterface $service
    ) {
    }

    /**
     * Display a listing of the contact messages.
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $status = $request->query('status');
        $search = $request->query('search');

        $messages = $this->service->getPaginatedMessages((int)$perPage, $status, $search);

        return new ContactMessageCollection($messages);
    }


    /**
     * Display the specified contact message.
     */
    public function show(ContactMessage $contact)
    {
        if (!$contact->read_at) {
            $this->service->markAsRead($contact);
        }

        return new ContactMessageResource($contact);
    }

    /**
     * Mark the message as read.
     */
    public function markAsRead(ContactMessage $contact)
    {
        $this->service->markAsRead($contact);

        return response()->json([
            'success' => true,
            'message' => 'Message marked as read.',
            'data' => new ContactMessageResource($contact)
        ]);
    }

    /**
     * Mark the message as unread.
     */
    public function markAsUnread(ContactMessage $contact)
    {
        $this->service->markAsUnread($contact);

        return response()->json([
            'success' => true,
            'message' => 'Message marked as unread.',
            'data' => new ContactMessageResource($contact)
        ]);
    }

    /**
     * Remove the specified contact message from storage.
     */
    public function destroy(ContactMessage $contact)
    {
        $this->service->deleteMessage($contact);

        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully.'
        ]);
    }
}
