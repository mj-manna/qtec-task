<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_bookings_index()
    {
        $response = $this->get('/bookings');
        
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_bookings_index()
    {
        /** @var User $user */
        $user = User::factory()->create(['role' => 'customer']);
        
        $response = $this->actingAs($user)->get('/bookings');
        
        $response->assertStatus(200);
    }

    public function test_admin_can_access_bookings_index()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)->get('/bookings');
        
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_access_bookings_create()
    {
        /** @var User $user */
        $user = User::factory()->create(['role' => 'customer']);
        
        $response = $this->actingAs($user)->get('/bookings/create');
        
        $response->assertStatus(200);
    }

    public function test_admin_can_access_bookings_create()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)->get('/bookings/create');
        
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_booking()
    {
        /** @var User $user */
        $user = User::factory()->create(['role' => 'customer']);
        $service = Service::create([
            'name' => 'Test Service',
            'description' => 'Test Description',
            'price' => 100.00,
            'status' => 'active'
        ]);

        $response = $this->actingAs($user)->post('/bookings', [
            'service_id' => $service->id,
            'booking_date' => now()->addDays(1)->format('Y-m-d')
        ]);

        $response->assertRedirect('/bookings');
        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'service_id' => $service->id
        ]);
    }

    public function test_admin_can_create_booking()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $service = Service::create([
            'name' => 'Test Service',
            'description' => 'Test Description',
            'price' => 100.00,
            'status' => 'active'
        ]);

        $response = $this->actingAs($admin)->post('/bookings', [
            'service_id' => $service->id,
            'booking_date' => now()->addDays(1)->format('Y-m-d')
        ]);

        $response->assertRedirect('/bookings');
        $this->assertDatabaseHas('bookings', [
            'user_id' => $admin->id,
            'service_id' => $service->id
        ]);
    }

    public function test_customer_cannot_update_booking_status()
    {
        /** @var User $user */
        $user = User::factory()->create(['role' => 'customer']);
        $service = Service::create([
            'name' => 'Test Service',
            'description' => 'Test Description',
            'price' => 100.00,
            'status' => 'active'
        ]);
        $booking = Booking::create([
            'user_id' => $user->id,
            'service_id' => $service->id,
            'booking_date' => now()->addDays(1),
            'status' => 'pending'
        ]);

        $response = $this->actingAs($user)->patch("/bookings/{$booking->id}/status", [
            'status' => 'confirmed'
        ]);

        $response->assertRedirect('/dashboard');
    }

    public function test_admin_can_update_booking_status()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        /** @var User $customer */
        $customer = User::factory()->create(['role' => 'customer']);
        $service = Service::create([
            'name' => 'Test Service',
            'description' => 'Test Description',
            'price' => 100.00,
            'status' => 'active'
        ]);
        $booking = Booking::create([
            'user_id' => $customer->id,
            'service_id' => $service->id,
            'booking_date' => now()->addDays(1),
            'status' => 'pending'
        ]);

        $response = $this->actingAs($admin)
            ->from('/bookings')
            ->patch("/bookings/{$booking->id}/status", [
                'status' => 'confirmed'
            ]);

        $response->assertRedirect('/bookings');
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'confirmed'
        ]);
    }
}
