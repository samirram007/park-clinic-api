<?php

namespace App\Http\Services\Contracts;

use App\Models\ContactMessage;

interface ContactServiceInterface
{
    /**
     * Submit a contact message.
     *
     * @param array<string, mixed> $data
     * @return ContactMessage
     */
    public function submit(array $data): ContactMessage;
}
