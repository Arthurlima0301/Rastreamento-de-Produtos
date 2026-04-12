<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saida extends Model
{
    use HasFactory;

    /** Disable timestamps because table follows schema exactly */
    public $timestamps = false;

    protected $fillable = [
        'data_saida',
    ];

    public function itens()
    {
        return $this->hasMany(SaidaItem::class, 'saida_id');
    }
}
