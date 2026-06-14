<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupplyInvoice extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'supply_invoices';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'supply_invoice_code',
        'issued_at',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'issued_at' => 'datetime',
    ];

    /**
     * Accessor to format the 'issued_at' attribute as 'd/m/Y' when accessed.
     */
    public function getFormattedIssuedAtAttribute(): string
    {
        return $this->issued_at->format('d/m/Y');
    }

    /**
     * Get the formatted invoice code.
     */
    public function getFormattedSupplyInvoiceCodeAttribute(): string
    {
        return number_format($this->supply_invoice_code, 0, '', '.');
    }

    /**
     * Get the supply items for the invoice.
     */
    public function supplyItems(): HasMany
    {
        return $this->hasMany(SupplyItem::class, 'supply_invoice_id');
    }

    /**
     * Scope a query to search invoices by invoice code.
     */
    public function scopeSearchBySupplyInvoiceCode($query, $search)
    {
        $search = trim(str_replace('.', '', (string) $search));

        return $query->when($search !== '', function ($query) use ($search) {
            $query->where('supply_invoice_code', 'like', $search.'%');
        });
    }
}
