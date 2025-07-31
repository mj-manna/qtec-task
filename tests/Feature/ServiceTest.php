<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_services_index()
    {
        $response = $this->get('/services');
        
        $response->assertRedirect('/login');
    }

    public function test_customer_cannot_access_services_index()
    {
        /** @var User $user */
        $user = User::factory()->create(['role' => 'customer']);
        
        $response = $this->actingAs($user)->get('/services');
        
        $response->assertRedirect('/dashboard');
    }

    public function test_admin_can_access_services_index()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)->get('/services');
        
        $response->assertStatus(200);
    }

    public function test_admin_can_access_services_create()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)->get('/services/create');
        
        $response->assertStatus(200);
    }

    public function test_customer_cannot_access_services_create()
    {
        /** @var User $user */
        $user = User::factory()->create(['role' => 'customer']);
        
        $response = $this->actingAs($user)->get('/services/create');
        
        $response->assertRedirect('/dashboard');
    }

    public function test_admin_can_create_service()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/services', [
            'name' => 'Test Service',
            'description' => 'Test Description',
            'price' => 100.00,
            'status' => 'active'
        ]);

        $response->assertRedirect('/services');
        $this->assertDatabaseHas('services', [
            'name' => 'Test Service'
        ]);
    }

    public function test_admin_can_access_service_edit()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $service = Service::create([
            'name' => 'Test Service',
            'description' => 'Test Description',
            'price' => 100.00,
            'status' => 'active'
        ]);
        
        $response = $this->actingAs($admin)->get("/services/{$service->id}/edit");
        
        $response->assertStatus(200);
    }

    public function test_customer_cannot_access_service_edit()
    {
        /** @var User $user */
        $user = User::factory()->create(['role' => 'customer']);
        $service = Service::create([
            'name' => 'Test Service',
            'description' => 'Test Description',
            'price' => 100.00,
            'status' => 'active'
        ]);
        
        $response = $this->actingAs($user)->get("/services/{$service->id}/edit");
        
        $response->assertRedirect('/dashboard');
    }

    public function test_admin_can_update_service()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $service = Service::create([
            'name' => 'Test Service',
            'description' => 'Test Description',
            'price' => 100.00,
            'status' => 'active'
        ]);

        $response = $this->actingAs($admin)->put("/services/{$service->id}", [
            'name' => 'Updated Service',
            'description' => 'Updated Description',
            'price' => 150.00,
            'status' => 'active'
        ]);

        $response->assertRedirect('/services');
        $this->assertDatabaseHas('services', [
            'name' => 'Updated Service'
        ]);
    }

    public function test_admin_can_delete_service()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $service = Service::create([
            'name' => 'Test Service',
            'description' => 'Test Description',
            'price' => 100.00,
            'status' => 'active'
        ]);

        $response = $this->actingAs($admin)->delete("/services/{$service->id}");

        $response->assertRedirect('/services');
        $this->assertDatabaseMissing('services', [
            'id' => $service->id
        ]);
    }
} 