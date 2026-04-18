<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NotaFiscal extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'nota_fiscal';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'codigo_nf',
        'data_emissao',
    ];

    /**
     * Accesor to format the 'data_emissao' attribute as 'd/m/Y' when accessed.
     */
    public function getDataEmissaoAttribute($value) : string
    {
        return date('d/m/Y', strtotime($value));
    }


    /**
     * Get the items for the nota fiscal.
     */
    public function itens() : HasMany
    {
        return $this->hasMany(Item::class, 'nota_fiscal_id');
    }
}
