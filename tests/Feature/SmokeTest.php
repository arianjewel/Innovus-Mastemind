<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\Product;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class SmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_render(): void
    {
        $product = Product::create(['title' => 'Test Pump', 'price' => 1000, 'currency' => 'BDT']);
        $project = Project::create(['title' => 'Test Bridge', 'type' => 'construction', 'status' => 'completed']);

        $this->get('/')->assertOk();
        $this->get('/about')->assertOk();
        $this->get('/services')->assertOk();
        $this->get('/products')->assertOk();
        $this->get("/products/{$product->slug}")->assertOk();
        $this->get('/projects')->assertOk();
        $this->get("/projects/{$project->slug}")->assertOk();
        $this->get('/contact')->assertOk();
        $this->get('/ebrochure')->assertOk();
    }

    public function test_guest_is_redirected_from_admin(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
    }

    public function test_pages_expose_ziggy_routes(): void
    {
        // Full payload on first generation, Object.assign merge on repeats — both contain route names.
        $this->get('/products')
            ->assertOk()
            ->assertSee('Ziggy')
            ->assertSee('"admin.products.index"', false);
    }

    public function test_non_admin_cannot_access_admin(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $this->actingAs($user)->get('/admin')->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_login_and_view_dashboard(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->post(route('admin.login'), [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);

        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('Admin/Dashboard'));
    }

    public function test_admin_crud_pages_render(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        foreach ([
            '/admin/sliders', '/admin/services', '/admin/categories', '/admin/brands',
            '/admin/products', '/admin/projects', '/admin/team-members', '/admin/clients',
            '/admin/brochures', '/admin/settings', '/admin/messages', '/admin/inquiries',
        ] as $uri) {
            $this->get($uri)->assertOk();
        }
    }

    public function test_contact_message_is_stored(): void
    {
        Message::query()->delete();

        $this->followingRedirects()->post('/contact', [
            'name' => 'Test Sender',
            'email' => 'sender@example.com',
            'phone' => '01700000000',
            'subject' => 'Hello',
            'message' => 'We need a quotation.',
        ])->assertOk();

        $this->assertDatabaseHas('messages', ['name' => 'Test Sender', 'subject' => 'Hello']);
    }
}
