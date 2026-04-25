<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'numero',
        'nota_fiscal_id',
        'insumo_id',
        'quantidade',
    ];

    /**
     * The balance append to the model.
     */
    protected $appends = ['saldo'];

    public function getSaldoAttribute() : float
    {
        return $this->quantidade - $this->saidas_items_sum_quantidade;
    }

    /**
     * Get the nota fiscal that owns the item.
     */
    public function notaFiscal() : BelongsTo
    {
        return $this->belongsTo(NotaFiscal::class, 'nota_fiscal_id');
    }

    /**
     * Get the insumo that owns the item.
     */
    public function insumo() : BelongsTo
    {
        return $this->belongsTo(Insumo::class, 'insumo_id');
    }

    /**
     * Get the saida items for the item.
     */
    public function saidasItems() : HasMany
    {
        return $this->hasMany(SaidaItem::class, 'item_id');
    }
}
