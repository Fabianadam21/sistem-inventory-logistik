<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OutgoingTransaction extends Model
{
    protected $fillable = [
        'transaction_number',
        'date',
        'department_id',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(OutgoingDetail::class);
    }
}