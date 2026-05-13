<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

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
     * Formatter quantity attribute accessor.
     */
    public function getFormattedQuantityAttribute(): string
    {
        return number_format($this->quantity, 2, ',', '.');
    }

    /**
     * Formated balance attribute accessor.
     */
    public function getFormattedBalanceAttribute(): string
    {
        return number_format($this->balance, 2, ',', '.');
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
                $query->where('name', 'like', $search . '%');
            });
        });
    }

    /**
     * Scope a query to calculate item balance.
     */
    public function scopewithBalance($query)
    {
        return $query
            ->select(
                'items.id',
                'items.supply_id',
                'items.invoice_id',
                'items.quantity',
                'supplies.name as supply_name',
                DB::raw('items.quantity - COALESCE(SUM(dispatch_items.quantity), 0) as balance')
            )
            ->join('supplies', 'supplies.id', '=', 'items.supply_id')
            ->join('invoices', 'invoices.id', '=', 'items.invoice_id')
            ->leftJoin('dispatch_items', 'dispatch_items.item_id', '=', 'items.id')
            ->groupBy(
                'items.id',
                'items.quantity',
                'supplies.name'
            );
    }

    /**
     * Scope a query to calculate item balance.
     */
    public function scopefilterBalance($query, $available = true)
    {
        return $query->when($available === true, function ($query) {
            $query->havingRaw('balance > 0');
        });
    }
}
