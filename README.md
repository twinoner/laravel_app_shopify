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

## Runing
To start both servers in the future, you can run them in separate terminals:

T1: `php artisan serve --port=8090`

T2: `npm run dev`

Open http://localhost:8090 in your browser to see the Vue app. The InstallButton component will render in the #app div with hot-reload enabled.


Service  URL

Laravel  http://localhost:8090

Vite HMR http://localhost:5173 (proxied through Laravel)

GraphQL  http://localhost:8090/graphql
