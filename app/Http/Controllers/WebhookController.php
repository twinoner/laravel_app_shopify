<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessWebhookJob;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handler(Request $request) {
        $hmac = $request->header('X-Shopify-Hmac-Sha256');
        $topic = $request->header('X-Shopify-Topic');
        $shopDomain = $request->header('X-Shopify-Shop-Domain');

        // Validate HMAC
        $shared = config('shopify.api_secret', env('SHOPIFY_API_SECRET'));
        $calculated = base64_encode(hash_hmac('sha256', $request->getContent(), $shared, true));
        if (! hash_equals($calculated, $hmac)) {
            Log::warning('Invalid webhook HMAC', ['shop' => $shopDomain, 'topic' => $topic]);
            return response('Invalid HMAC', 401);
        }

        $shop = Shop::where('shopify_domain', $shopDomain)->first();
        if (! $shop) {
            Log::warning('Webhook for unknown shop', ['shop' => $shopDomain]);
            return response('Unknown shop', 400);
        }

        $event = $shop->webhookEvents()->create([
            'topic' => $topic,
            'payload' => json_decode($request->getContent(), true),
            'shopify_hmac' => $hmac,
        ]);

        ProcessWebhookJob::dispatch($event);

        return response('OK', 200);
    }
}
