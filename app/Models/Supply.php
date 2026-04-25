<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];
}
