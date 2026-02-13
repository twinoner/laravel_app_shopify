<?php

namespace App\Jobs;

use App\Models\WebhookEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public WebhookEvent $event;

    public function __construct(WebhookEvent $event) {
        $this->event = $event;
    }

    public function handle() {
        // Example: mark as processed. Replace with real business logic.
        $this->event->processed = true;
        $this->event->save();
    }
}
