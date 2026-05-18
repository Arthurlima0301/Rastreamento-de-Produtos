<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the supplies for the client.
     */
    public function supplies(): HasMany
    {
        return $this->hasMany(Supply::class, 'client_id');
    }

    /**
     * Scope a query to search clients by name.
     */
    public function scopeSearchByName($query, $search)
    {
        $search = trim((string) $search);

        return $query->when($search !== '', function ($query) use ($search) {
            $query->where('name', 'like', $search.'%');
        });
    }
}
