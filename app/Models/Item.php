<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'items';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'number',
        'invoice_id',
        'supply_id',
        'quantity',
    ];

    /**
     * The balance append to the model.
     */
    protected $appends = ['balance'];

    public function getBalanceAttribute(): float
    {
        return $this->quantity - ($this->dispatch_items_sum_quantity ?? 0);
    }

    /**
     * Get the invoice that owns the item.
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    /**
     * Get the supply that owns the item.
     */
    public function supply(): BelongsTo
    {
        return $this->belongsTo(Supply::class, 'supply_id');
    }

    /**
     * Get the dispatch items for the item.
     */
    public function dispatchItems(): HasMany
    {
        return $this->hasMany(DispatchItem::class, 'item_id');
    }

    /**
     * Scope a query to search items by supply name.
     */
    public function scopeSearchBySupplyName($query, $search)
    {
        $search = trim((string) $search);

        return $query->when($search !== '', function ($query) use ($search) {
            $query->whereHas('supply', function ($query) use ($search) {
                $query->where('name', 'like', $search.'%');
            });
        });
    }
}
