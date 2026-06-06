<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Load extends Model
{
    /** @use HasFactory<\Database\Factories\LoadFactory> */
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'loads';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
           'number',
           'cutted_at',
           'turn',
           'observation',
           'machine_id'
    ];

    /**
     * Formatted cutted_at
     */
    public function getFormattedCuttedAtAtributte()
    {
        return date('d/m/Y', strtotime($this->cutted_at));
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

    /**
     * Scope a query to search loads.
     */

}
