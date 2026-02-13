<?php

namespace App\GraphQL\Resolvers;

use App\Models\Shop;

class ShopResolver
{
    public function shopByDomain($root, array $args) {
        return Shop::where('shopify_domain', $args['domain'])->first();
    }
}