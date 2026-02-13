# Shopify Laravel Starter

Minimal starter for a Shopify app (Laravel + Lighthouse + Vue 3).

## Setup
1. Copy `.env.example` -> `.env` and set values (SHOPIFY_API_KEY, SHOPIFY_API_SECRET, APP_URL).
2. `composer install`
3. `npm install`
4. `php artisan key:generate`
5. `php artisan migrate`
6. `php artisan queue:work` (or use Supervisor in production)
7. Expose local app with ngrok and configure Shopify Partner App redirect & webhook URLs.

## What is included
- OAuth install flow
- Webhook receiver + queued job
- Lighthouse GraphQL schema (shop, webhook events)
- Vue 3 admin with Apollo Client
- Unit & Feature tests for OAuth and webhook
