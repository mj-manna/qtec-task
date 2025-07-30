<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Service;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = $request->user()->bookings()->with('service')->latest()->get();

        return Inertia::render('customer/bookings/index', [
            'bookings' => $bookings
        ]);
    }

    public function create()
    {
        return Inertia::render('customer/bookings/create', [
            'services' => Service::active()->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after:today',
        ]);

        Booking::create([
            'user_id' => $request->user()->id,
            'service_id' => $request->service_id,
            'booking_date' => $request->booking_date,
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking->update([
            'status' => $request->status
        ]);

        $statusMessage = match($request->status) {
            'confirmed' => 'Booking approved successfully.',
            'cancelled' => 'Booking cancelled.',
            default => 'Booking status updated.',
        };

        return redirect()->back()->with('success', $statusMessage);
    }
}
