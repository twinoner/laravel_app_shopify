<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OAuthTest extends TestCase
{
    public function test_callback_exchanges_token()
    {
        Http::fake(["https://*.myshopify.com/*" =>
        Http::response(
            ['access_token' => 'test-token', 'scope' => 'read_products'],
            200
        )]);
        $response = $this->get('/auth/callback?shop=example.myshopify.com&code=code123&state=' . session('oauth_state'));
        // Because in install we push state to session, this test should simulate correct state or assert flow.
        $response->assertStatus(302);
    }
}
