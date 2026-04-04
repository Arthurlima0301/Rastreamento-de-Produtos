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

    public function notaFiscal()
    {
        return $this->belongsTo(NotaFiscal::class, 'nota_fiscal_id');
    }

    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'insumo_id');
    }
}
