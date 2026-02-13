<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ShopifyService
{
    public static function registerWebhook($shopDomain, $accessToken, $topic, $address) {
        $resp = Http::withHeaders([
            'X-Shopify-Access-Token' => $accessToken,
            'Content-Type' => 'application/json',
        ])->post("https://{$shopDomain}/admin/api/2023-10/webhooks.json", [
            'webhook' => [
                'topic' => $topic,
                'address' => $address,
                'format' => 'json',
            ],
        ]);
        return $resp->json();
    }
}