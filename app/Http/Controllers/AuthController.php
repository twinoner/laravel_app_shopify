<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function install(Request $request) {
        $validated = $request->validate([
            'shop' => ['required', 'string'],
        ]);
        $shop = preg_replace('#^https?://#i', '', $validated['shop']);

        $state = bin2hex(random_bytes(12));
        $request->session()->put('oauth_state', $state);
        $scopes = config('shopify.scopes', env('SHOPIFY_SCOPES'));
        $apiKey = config('shopify.api_key', env('SHOPIFY_API_KEY'));
        $redirect = route('auth.callback');
        $installUrl = "https://{$shop}/admin/oauth/authorize?client_id={$apiKey}&scope={$scopes}&redirect_uri={$redirect}&state={$state}";
        return redirect()->away($installUrl);
    }

    public function callback(Request $request) {

        $validated = $request->validate([
            'hmac' => ['required', 'string'],
            'shop' => ['required', 'string'],
            'code' => ['required', 'string'],
            'state' => ['required', 'string'],
        ]);
        $hmac = $validated['hmac'];
        $shop = preg_replace('#^https?://#i', '', $validated['shop']);
        $code = $validated['code'];
        $state = $validated['state'];

        if ($state !== $request->session()->pull('oauth_state')) {
            abort(403, 'Invalid state');
        }

        // Exchange code for token
        $resp = Http::asForm()->post("https://{$shop}/admin/oauth/access_token", [
            'client_id' => config('shopify.api_key'),
            'client_secret' => config('shopify.api_secret'),
            'code' => $code,
        ]);

        if (! $resp->ok()) {
            abort(500, 'Failed to exchange token');
        }

        $data = $resp->json();

        $token = $data['access_token'];
        $scopes = $data['scope'] ?? null;

        $shopModel = Shop::updateOrCreate(
            ['shopify_domain' => $shop],
            ['access_token' => $token, 'scope' => $scopes, 'installed_at' => now()]
        );

        // Optionally register webhooks here (example omitted for brevity)

        return redirect('/'); // or to your embedded app admin route
    }
}
