<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'invoices';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'invoice_code',
        'issued_at',
    ];

    /**
     * Accessor to format the 'issued_at' attribute as 'd/m/Y' when accessed.
     */
    public function getIssuedAtAttribute($value): string
    {
        return date('d/m/Y', strtotime($value));
    }

    /**
     * Get the items for the invoice.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'invoice_id');
    }
}
