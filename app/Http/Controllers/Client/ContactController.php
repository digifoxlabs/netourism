<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryReceived;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Handle AJAX enquiry submission.
     */
    public function submit(Request $request): JsonResponse
    {
        $payload = $request->only([
            'name',
            'contact',
            'email',
            'trip_type',
            'trip_type_other',
            'destinations',
            'travellers',
            'vehicle',
            'dates',
            'self_drive',
            'message',
        ]);

        $validator = Validator::make($payload, [
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'trip_type' => 'required|string|max:255',
            'trip_type_other' => 'nullable|string|max:255',
            'destinations' => 'required|string|max:1000',
            'travellers' => 'required|string|max:20',
            'vehicle' => 'required|string|max:50',
            'dates' => 'nullable|string|max:2000',     // comma-separated YYYY-MM-DD
            'self_drive' => 'nullable|string|in:Yes,No',
            'message' => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Prepare and normalize data
        $datesRaw = trim($payload['dates'] ?? '');
        $datesArray = [];
        if ($datesRaw !== '') {
            // Accept both comma-separated and comma+space
            $datesArray = array_filter(array_map('trim', explode(',', $datesRaw)));
        }

        $destinationsRaw = trim($payload['destinations'] ?? '');
        $destinationsArray = [];
        if ($destinationsRaw !== '') {
            $destinationsArray = array_filter(array_map('trim', explode(',', $destinationsRaw)));
        }

        $data = [
            'name' => Str::title(trim($payload['name'])),
            'contact' => trim($payload['contact']),
            'email' => $payload['email'] ? trim($payload['email']) : null,
            'trip_type' => trim($payload['trip_type']),
            'trip_type_other' => $payload['trip_type_other'] ? trim($payload['trip_type_other']) : null,
            'destinations_raw' => $destinationsRaw,
            'destinations' => $destinationsArray,
            'travellers' => trim($payload['travellers']),
            'vehicle' => trim($payload['vehicle']),
            'dates_raw' => $datesRaw,
            'dates' => $datesArray,
            'self_drive' => in_array(trim($payload['self_drive'] ?? ''), ['Yes', 'yes', 'Y', 'y', '1'], true) ? 'Yes' : 'No',
            'message' => $payload['message'] ? trim($payload['message']) : null,
            'received_at' => now()->toDateTimeString(),
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ];

        $adminEmail = config('mail.admin_address', env('MAIL_ADMIN_ADDRESS', env('MAIL_FROM_ADDRESS', 'admin@example.com')));

        try {
            Mail::to($adminEmail)->send(new InquiryReceived($data));
        } catch (\Exception $e) {
            Log::error('Inquiry email failed: '.$e->getMessage(), ['payload' => $data]);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send email. Please try again later.'
            ], 500);
        }

        return response()->json([
            'status' => 'ok',
            'message' => 'Your enquiry was sent successfully. We will contact you shortly.'
        ], 200);
    }
}
