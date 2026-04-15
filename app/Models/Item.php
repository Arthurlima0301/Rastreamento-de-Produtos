<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'nota_fiscal_id',
        'insumo_id',
        'quantidade',
    ];

    /**
     * The balance append to the model.
     */
    protected $appends = ['saldo'];

    public function getSaldoAttribute()
    {
        return $this->quantidade - $this->saidas_items_sum_quantidade;
    }

    /**
     * Get the nota fiscal that owns the item.
     */
    public function notaFiscal()
    {
        return $this->belongsTo(NotaFiscal::class, 'nota_fiscal_id');
    }

    /**
     * Get the insumo that owns the item.
     */
    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'insumo_id');
    }

    /**
     * Get the saida items for the item.
     */
    public function saidasItems()
    {
        return $this->hasMany(SaidaItem::class, 'item_id');
    }
}
