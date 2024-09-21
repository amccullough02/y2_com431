<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IntegrityTest extends TestCase
{

    use RefreshDatabase;

    // Set up.

    public function setUp(): void {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    // Does the admin acc exist?

    public function test_admin_account_exists() {

        $this->assertDatabaseHas('users', [
            'email' => 'admin@images-app.com',
        ]);

    }

    // Do the three other user accounts exist?

    public function test_three_user_accounts_exist() {

        $this->assertDatabaseCount('users', 4);
        // 1 admin account, 3 user accounts -> four in total

    }

    // Are there eight posts?

    public function test_eight_posts_seeded() {

        $this->assertDatabaseCount('posts', 8);

    }

}
