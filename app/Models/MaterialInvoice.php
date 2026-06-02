<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialInvoice extends Model
{
    use HasFactory;

    protected $table = 'material_invoice';

    protected $fillable = [
        'invoice_code',
        'issued_at',
    ];

    public function getFormattedIssuedAtAttribute(): string
    {
        $timestamp = strtotime((string) $this->issued_at);

        if ($timestamp === false) {
            return (string) $this->issued_at;
        }

        return date('d/m/Y', $timestamp);
    }

    public function getFormattedInvoiceCodeAttribute(): string
    {
        if (! is_numeric($this->invoice_code)) {
            return (string) $this->invoice_code;
        }

        return number_format((float) $this->invoice_code, 0, '', '.');
    }

    public function scopeSearchByInvoiceCode($query, $search)
    {
        $search = trim(str_replace('.', '', (string) $search));

        return $query->when($search !== '', function ($query) use ($search) {
            $query->where('invoice_code', 'like', $search.'%');
        });
    }
}
