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
        $isImportant = $request->has('important') ? $request->boolean('important') : null;

        $messages = $this->service->getPaginatedMessages((int)$perPage, $status, $search, $isImportant);

        return new ContactMessageCollection($messages);
    }

    /**
     * Toggle the importance status of the message.
     */
    public function toggleImportant(ContactMessage $contact)
    {
        $message = $this->service->toggleImportant($contact);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'data' => new ContactMessageResource($message)
        ]);
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
     * Reply to the contact message.
     */
    public function reply(\App\Http\Requests\ReplyRequest $request, ContactMessage $contact)
    {
        $message = $this->service->reply($contact, $request->validated()['reply_message']);

        return response()->json([
            'success' => true,
            'message' => 'Message replied successfully.',
            'data' => new ContactMessageResource($message)
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
