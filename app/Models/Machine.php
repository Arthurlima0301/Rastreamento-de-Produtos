<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Machine extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'abbreviation',
    ];

    /**
     * Get the loads for the machine.
     */
    public function loads(): HasMany
    {
        return $this->hasMany(Load::class, 'machine_id');
    }

    /**
     * Search by name.
     */
    public function scopeSearchByName($query, $search)
    {
        $search = trim((string) $search);

        return $query->when($search !== '', function ($query) use ($search) {
            $query->where('name', 'like', $search.'%');
        });
    }
}
