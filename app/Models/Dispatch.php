<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dispatch extends Model
{
    use HasFactory;

    /** Disable timestamps because table follows schema exactly */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'dispatched_at',
        'invoice',
    ];

    /**
     * Accessor to format the 'dispatched_at' attribute as 'd/m/Y' when accessed.
     */
    public function getDispatchedAtAttribute($value): string
    {
        return date('d/m/Y', strtotime($value));
    }

    /**
     * Get the items for the dispatch.
     */
    public function items(): HasMany
    {
        return $this->hasMany(DispatchItem::class, 'dispatch_id');
    }

    /**
     * Scope a query to search dispatches by invoice.
     */
    public function scopeSearchByInvoice($query, $search)
    {
        $search = trim((string) $search);

        return $query->when($search !== '', function ($query) use ($search) {
            $query->where('invoice', 'like', $search.'%');
        });
    }
}
