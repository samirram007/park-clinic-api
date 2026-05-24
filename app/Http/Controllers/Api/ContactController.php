<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Services\Contracts\ContactServiceInterface;

class ContactController extends Controller
{
    public function __invoke(
        ContactRequest $request,
        ContactServiceInterface $service
    ) {
        $service->submit($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully.',
        ]);
    }
}
