<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DispatchItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'dispatch_items';

    /**
     * The attributes that are mass assignable.
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     * @return array<string, string, float>
     */
    protected $fillable = [
        'dispatch_id',
        'item_id',
        'quantity',
    ];

    /*
    * Formatter quantity attribute accessor.
    */
    public function getFormattedQuantityAttribute(): string
    {
        return number_format($this->quantity,2,',','.');
    }

    /**
     * Get the dispatch that owns the dispatch item.
     */
    public function dispatch(): BelongsTo
    {
        return $this->belongsTo(Dispatch::class, 'dispatch_id');
    }

    /**
     * Get the item that owns the dispatch item.
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
