<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaterialInvoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'material_invoice_code',
    ];

    /**
     * Get the material items for the material invoice.
     */
    public function materialItems(): HasMany
    {
        return $this->hasMany(MaterialItem::class, 'material_invoice_id');
    }

    /**
     * Get the formatted material invoice code.
     */
    protected function getFormattedMaterialInvoiceCodeAttribute(): string
    {
        return number_format($this->material_invoice_code, 0, '', '.');
    }

    /**
     * Accessor to format the 'created_at' attribute as 'd/m/Y' when accessed.
     */
    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at?->format('d/m/Y') ?? '';
    }

    /**
     * Scope a query to search material invoices by code.
     */
    public function scopeSearchByMaterialInvoiceCode($query, $search)
    {
        $search = trim(str_replace('.', '', (string) $search));

        return $query->when($search !== '', function ($query) use ($search) {
            $query->where('material_invoice_code', 'like', $search.'%');
        });
    }
}
