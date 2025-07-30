<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return Inertia::render('admin/dashboard', [
                'bookings' => Booking::with(['user', 'service'])->latest()->get(),
                'stats' => [
                    'total_services' => Service::count(),
                    'total_bookings' => Booking::count(),
                    'pending_bookings' => Booking::where('status', 'pending')->count(),
                ]
            ]);
        }

        return Inertia::render('customer/dashboard', [
            'services' => Service::active()->get(),
            'bookings' => $user->bookings()->with('service')->latest()->get(),
        ]);
    }
}
