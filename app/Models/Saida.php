<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Saida extends Model
{
    use HasFactory;

    /** Disable timestamps because table follows schema exactly */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'data_saida',
    ];

    /**
     * Accesor to format the 'data_saida' attribute as 'd/m/Y' when accessed.
     */
    public function getDataSaidaAttribute($value) : string
    {
        return date('d/m/Y', strtotime($value));
    }

    /**
     * Get the items for the saida.
     */
    public function items() : HasMany
    {
        return $this->hasMany(SaidaItem::class, 'saida_id');
    }
}
