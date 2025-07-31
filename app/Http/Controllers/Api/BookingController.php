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
     * 
     * @OA\Get(
     *     path="/bookings",
     *     tags={"Bookings"},
     *     summary="Get user's bookings",
     *     description="Retrieve all bookings for the authenticated user",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="User bookings retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Booking"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
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
     * 
     * @OA\Post(
     *     path="/bookings",
     *     tags={"Bookings"},
     *     summary="Create a new booking",
     *     description="Create a new booking for a service",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"service_id","booking_date"},
     *             @OA\Property(property="service_id", type="integer", example=1),
     *             @OA\Property(property="booking_date", type="string", format="date", example="08/01/2025")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Booking created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Booking created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Booking")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request - Service not available or duplicate booking",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Service is not available for booking")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
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
            ->whereDate('booking_date', $request->booking_date)
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
     * 
     * @OA\Get(
     *     path="/admin/bookings",
     *     tags={"Bookings"},
     *     summary="Get all bookings (admin only)",
     *     description="Retrieve all bookings in the system (admin only)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="All bookings retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Booking"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden - Admin access required",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Forbidden.")
     *         )
     *     )
     * )
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
