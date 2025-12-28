<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_admin_and_agent_helpers(): void
    {

        dump([
            'env' => app()->environment(),
            'db_default' => config('database.default'),
            'db_name' => config('database.connections.'.config('database.default').'.database'),
        ]);

        $admin = User::factory()->create(['role' => 'admin']);
        $agent = User::factory()->create(['role' => 'agent']);
        $user = User::factory()->create(['role' => 'user']);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isAgent());

        $this->assertTrue($agent->isAgent());
        $this->assertFalse($agent->isAdmin());

        $this->assertFalse($user->isAdmin());
        $this->assertFalse($user->isAgent());
    }
}
