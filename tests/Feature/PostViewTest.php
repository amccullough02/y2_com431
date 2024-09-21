<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class PostViewTest extends TestCase
{

    use RefreshDatabase;

    // Set up.

    public function setUp(): void {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    // Login redirect to posts.

    public function test_login_redirect_to_posts() {

        $response = $this->post('login', [
            'email' => 'admin@images-app.com',
            'password' => 'admin1234'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('posts');

    }

    // Paginated posts table shows the most recently modified item.

    public function test_paginated_posts_table_shows_last_item() {

        $user = User::all()->first(); // Using the admin account.

        $lastPost = DB::table('posts')->latest()->first();

        $response = $this->actingAs($user)->get('posts');

        $response->assertStatus(200);
        $response->assertViewHas('posts', $lastPost);

    }

}
