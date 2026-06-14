<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supply extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'supplies';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'supply_code',
        'name',
        'unit_of_measure',
        'client_id',
    ];

    /**
     * Get the client that owns the supply.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Get the supply items associated with the supply.
     */
    public function supplyItems(): HasMany
    {
        return $this->hasMany(SupplyItem::class, 'supply_id');
    }

    /**
     * Scope a query to search supplies by name.
     */
    public function scopeSearchByName($query, $search)
    {
        $search = trim((string) $search);

        return $query->when($search !== '', function ($query) use ($search) {
            $query->where('name', 'like', $search.'%');
        });
    }
}
