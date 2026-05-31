<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'client_id',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function scopeSearchByOrderCode($query, $search)
    {
        $search = trim((string) $search);

        return $query->when($search !== '', function ($query) use ($search) {
            $query->where('order_code', 'like', $search.'%');
        });
    }
}
