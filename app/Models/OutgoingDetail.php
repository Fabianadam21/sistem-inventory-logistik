<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OutgoingDetail extends Model
{
    protected $fillable = [
        'outgoing_transaction_id',
        'item_id',
        'quantity',
        'description',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(
            OutgoingTransaction::class,
            'outgoing_transaction_id'
        );
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}