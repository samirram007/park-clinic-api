<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Get the chat widget visibility status (public).
     */
    public function getChatWidget(): JsonResponse
    {
        $setting = Setting::where('key', 'chat_widget_enabled')->first();

        return response()->json([
            'enabled' => $setting?->value === 'true',
        ]);
    }

    /**
     * Update the chat widget visibility status (admin only).
     */
    public function updateChatWidget(Request $request): JsonResponse
    {
        $request->validate([
            'enabled' => ['required', 'boolean'],
        ]);

        Setting::updateOrCreate(
            ['key' => 'chat_widget_enabled'],
            ['value' => $request->boolean('enabled') ? 'true' : 'false'],
        );

        return response()->json([
            'message' => 'Chat widget settings updated successfully.',
            'enabled' => $request->boolean('enabled'),
        ]);
    }
}
