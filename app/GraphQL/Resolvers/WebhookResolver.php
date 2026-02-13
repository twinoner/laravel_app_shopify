<?php

namespace App\GraphQL\Resolvers;

use App\Models\WebhookEvent;

class WebhookResolver
{
    public function listForShop($root, array $args) {
        return WebhookEvent::where('shop_id', $args['shopId'])->orderBy('created_at', 'desc')->get();
    }
}