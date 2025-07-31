<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the authenticated user's bookings
     */
    public function index(Request $request)
    {
        $bookings = Booking::with(['service'])
            ->where('user_id', $request->user()->id)
            ->orderBy('booking_date', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $bookings
        ]);
    }

    /**
     * Store a newly created booking
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after:today',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if service is active
        $service = Service::find($request->service_id);
        if ($service->status !== 'active') {
            return response()->json([
                'status' => 'error',
                'message' => 'Service is not available for booking'
            ], 400);
        }

        // Check for duplicate booking on same date for same user and service
        $existingBooking = Booking::where('user_id', $request->user()->id)
            ->where('service_id', $request->service_id)
            ->where('booking_date', $request->booking_date)
            ->first();

        if ($existingBooking) {
            return response()->json([
                'status' => 'error',
                'message' => 'You already have a booking for this service on this date'
            ], 400);
        }

        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'service_id' => $request->service_id,
            'booking_date' => $request->booking_date,
            'status' => 'pending',
        ]);

        $booking->load(['service', 'user']);

        return response()->json([
            'status' => 'success',
            'message' => 'Booking created successfully',
            'data' => $booking
        ], 201);
    }

    /**
     * Display a listing of all bookings (admin only)
     */
    public function adminIndex()
    {
        $bookings = Booking::with(['service', 'user'])
            ->orderBy('booking_date', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $bookings
        ]);
    }
}
