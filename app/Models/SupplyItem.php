<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class SupplyItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'supply_items';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'number',
        'supply_invoice_id',
        'supply_id',
        'quantity',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'quantity' => 'float',
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
     * Get the supply invoice that owns the supply item.
     */
    public function supplyInvoice(): BelongsTo
    {
        return $this->belongsTo(SupplyInvoice::class, 'supply_invoice_id');
    }

    /**
     * Get the supply that owns the supply item.
     */
    public function supply(): BelongsTo
    {
        return $this->belongsTo(Supply::class, 'supply_id');
    }

    /**
     * Get the dispatch items for the supply item.
     */
    public function dispatchItems(): HasMany
    {
        return $this->hasMany(DispatchItem::class, 'supply_item_id');
    }

    /**
     * Scope a query to search supply items by supply name.
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
     * Scope a query to calculate supply item balance.
     */
    public function scopeWithBalance($query)
    {
        return $query
            ->select(
                'supply_items.id',
                'supply_items.number',
                'supply_items.supply_id',
                'supply_items.supply_invoice_id',
                'supply_items.quantity',
                'supplies.name as supply_name',
                DB::raw('supply_items.quantity - COALESCE(SUM(dispatch_items.quantity), 0) as balance')
            )
            ->join('supplies', 'supplies.id', '=', 'supply_items.supply_id')
            ->join('supply_invoices', 'supply_invoices.id', '=', 'supply_items.supply_invoice_id')
            ->leftJoin('dispatch_items', 'dispatch_items.supply_item_id', '=', 'supply_items.id')
            ->groupBy(
                'supply_items.id',
                'supply_items.quantity',
                'supplies.name'
            );
    }

    /**
     * Scope a query to calculate supply item frequence.
     */
    public function scopewithFrequency($query)
    {
        return $query
            ->addSelect(
                DB::raw('COUNT(dispatch_items.supply_item_id) as frequence')
            )
            ->orderBy('frequence','desc');
    }

    /**
     * Scope a query to calculate supply item balance.
     */
    public function scopeFilterBalance($query, $available = true)
    {
        return $query->when($available === true, function ($query) {
            $query->havingRaw('balance > 0');
        });
    }
}
