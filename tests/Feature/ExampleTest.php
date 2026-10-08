<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the landing page returns a successful response.
     */
    public function test_landing_page_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test legacy multipage routes redirect to landing page anchors.
     */
    public function test_legacy_routes_redirect_to_landing_page_anchors(): void
    {
        $this->get('/services')
            ->assertStatus(301)
            ->assertRedirect('/#solusi');

        $this->get('/pricing')
            ->assertStatus(301)
            ->assertRedirect('/#harga');

        $this->get('/contact')
            ->assertStatus(301)
            ->assertRedirect('/#kontak');
    }

    /**
     * Test FAQ page returns a successful response.
     */
    public function test_faq_page_returns_a_successful_response(): void
    {
        $response = $this->get('/faq');

        $response->assertStatus(200);
    }

    /**
     * Test Blog page returns a successful response.
     */
    public function test_blog_page_returns_a_successful_response(): void
    {
        $response = $this->get('/blog');

        $response->assertStatus(200);
    }
}
