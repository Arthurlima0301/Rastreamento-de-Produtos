<?php

namespace App\Models;

use Database\Factories\LoadFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Load extends Model
{
    /** @use HasFactory<LoadFactory> */
    use HasFactory;

    protected $table = 'loads';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'cutted_at',
        'turn',
        'observation',
        'machine_id',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'cutted_at' => 'date',
    ];

    /**
     * Formatted cutted_at
     */
    public function getFormattedCuttedAtAttribute()
    {
        return $this->cutted_at?->format('d/m/Y');
    }

    /**
     * Get the machine that owns the load.
     */
    public function machine()
    {
        return $this->belongsTo(Machine::class, 'machine_id');
    }

    /**
     * Get the rolls for the load.
     */
    public function rolls()
    {
        return $this->hasMany(Roll::class, 'load_id');
    }
}
