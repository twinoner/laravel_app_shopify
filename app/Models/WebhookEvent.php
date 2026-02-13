<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebhookEvent extends Model
{
    use SoftDeletes;

    protected $table = 'webhook_events';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'shop_id',
        'topic',
        'payload',
        'shopify_hmac',
        'processed',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'processed' => 'boolean',
        ];
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
