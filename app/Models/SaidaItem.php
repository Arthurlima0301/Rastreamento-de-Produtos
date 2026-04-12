<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaidaItem extends Model
{
    use HasFactory;

    protected $table = 'saidas_items';

    public $timestamps = true;

    protected $fillable = [
        'saida_id',
        'item_id',
        'quantidade',
    ];

    public function saida()
    {
        return $this->belongsTo(Saida::class, 'saida_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
