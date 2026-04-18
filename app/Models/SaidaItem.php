<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class SaidaItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'saidas_items';

    /**
     * The attributes that are mass assignable.
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     * @return array<string, string, float>
     */
    protected $fillable = [
        'saida_id',
        'item_id',
        'quantidade',
    ];

    /**
     * Get the saida that owns the saida item.
     */
    public function saida() : BelongsTo
    {
        return $this->belongsTo(Saida::class, 'saida_id');
    }

    /**
     * Get the item that owns the saida item.
     */
    public function item() : BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
