<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $fillable = [
        'code',
        'name',
        'category_id',
        'unit_id',
        'supplier_id',
        'stock',
        'minimum_stock',
        'price',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function incomingDetails(): HasMany
    {
        return $this->hasMany(IncomingDetail::class);
    }

    public function outgoingDetails(): HasMany
    {
        return $this->hasMany(OutgoingDetail::class);
    }
}