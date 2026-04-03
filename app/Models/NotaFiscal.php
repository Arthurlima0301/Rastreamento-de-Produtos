<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaFiscal extends Model
{
    use HasFactory;

    protected $table = 'nota_fiscal';

    protected $fillable = [
        'codigo_nf',
        'data_emissao',
    ];

    protected $dates = [
        'data_emissao',
    ];
}
