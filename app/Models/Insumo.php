<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Insumo extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'insumos';

    /**
     * The attributes that are mass assignable. 
     */
    protected $fillable = [
        'codigo_insumo',
        'nome',
        'unidade_medida',
    ];
    
}
