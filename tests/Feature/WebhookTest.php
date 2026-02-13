<?php

namespace Tests\Feature;

use App\Models\Shop;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class WebhookTest extends TestCase
{
    public function test_webhook_persists_and_dispatches_job()
    {
        Queue::fake();
        $shop = Shop::factory()->create(['shopify_domain' =>
        'example.myshopify.com', 'access_token' => 'token']);
        $payload = ['id' => 1, 'title' => 'Test'];
        $hmac = base64_encode(hash_hmac(
            'sha256',
            json_encode($payload),
            config('shopify.api_secret', env('SHOPIFY_API_SECRET')),
            true
        ));
        $response = $this->withHeaders([
            'X-Shopify-Hmac-Sha256' => $hmac,
            'X-Shopify-Topic' => 'products/create',
            'X-Shopify-Shop-Domain' => 'example.myshopify.com',
        ])->postJson('/webhook', $payload);
        $response->assertStatus(200);
        Queue::assertPushed(\App\Jobs\ProcessWebhookJob::class);
    }
}
