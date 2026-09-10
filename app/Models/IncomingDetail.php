<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncomingDetail extends Model
{
    protected $fillable = [
        'incoming_transaction_id',
        'item_id',
        'quantity',
        'price',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(
            IncomingTransaction::class,
            'incoming_transaction_id'
        );
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}