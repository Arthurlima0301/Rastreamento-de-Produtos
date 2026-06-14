<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaterialInvoice extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'material_invoice';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'invoice_code',
        'issued_at',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'issued_at' => 'date',
    ];

    /**
     * Format the issued date attribute.
     */
    public function getFormattedIssuedAtAttribute(): string
    {
        return  $this->issued_at->format('d/m/Y');
    }

    /**
     * Format the invoice code attribute.
     */
    public function getFormattedInvoiceCodeAttribute(): string
    {
        if (! is_numeric($this->invoice_code)) {
            return (string) $this->invoice_code;
        }

        return number_format((float) $this->invoice_code, 0, '', '.');
    }

    /**
     * Get the item materials for the invoice.
     */
    public function itemMaterials(): HasMany
    {
        return $this->hasMany(ItemMaterial::class, 'material_invoice_id');
    }

    /**
     * Scope a query to search invoices by code.
     */
    public function scopeSearchByInvoiceCode($query, $search)
    {
        $search = trim(str_replace('.', '', (string) $search));

        return $query->when($search !== '', function ($query) use ($search) {
            $query->where('invoice_code', 'like', $search.'%');
        });
    }
}
