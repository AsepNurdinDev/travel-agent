<?php

namespace Tests\Feature\Authorization;

use App\Models\Payment;
use App\Models\TourPackage;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
    }

    public function test_finance_cannot_delete_a_tour_package(): void
    {
        $finance = User::query()->where('email', 'finance@travelagent.test')->firstOrFail();
        $package = TourPackage::factory()->create();

        $this->assertFalse($finance->can('delete', $package));
    }

    public function test_finance_can_view_payments_but_cannot_create_one_directly(): void
    {
        $finance = User::query()->where('email', 'finance@travelagent.test')->firstOrFail();
        $payment = Payment::factory()->create();

        $this->assertTrue($finance->can('view', $payment));
        // Payments are only ever created through PaymentService, never a bare form.
        $this->assertFalse($finance->can('create', Payment::class));
        // Payments are never deleted, only refunded, regardless of role.
        $this->assertFalse($finance->can('delete', $payment));
    }

    public function test_super_admin_bypasses_every_check(): void
    {
        $superAdmin = User::query()->where('email', 'superadmin@travelagent.test')->firstOrFail();
        $package = TourPackage::factory()->create();

        $this->assertTrue($superAdmin->can('delete', $package));
        $this->assertTrue($superAdmin->can('create', TourPackage::class));
    }

    public function test_sales_cannot_manage_blog_content(): void
    {
        $sales = User::query()->where('email', 'sales@travelagent.test')->firstOrFail();

        $this->assertFalse($sales->can('blog_posts.create'));
    }

    public function test_content_manager_cannot_view_payments(): void
    {
        $content = User::query()->where('email', 'content@travelagent.test')->firstOrFail();

        $this->assertFalse($content->can('payments.view'));
    }

    public function test_only_staff_roles_can_access_the_admin_panel(): void
    {
        $plainUser = User::factory()->create();
        $admin = User::query()->where('email', 'admin@travelagent.test')->firstOrFail();

        $this->assertFalse($plainUser->hasAnyRole(['super_admin', 'admin', 'sales', 'finance', 'content_manager']));
        $this->assertTrue($admin->hasAnyRole(['super_admin', 'admin', 'sales', 'finance', 'content_manager']));
    }
}
