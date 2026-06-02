<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemMaterial extends Model
{
    use HasFactory;

    protected $table = 'item_material';

    protected $fillable = [
        'number',
        'material_id',
        'material_invoice_id',
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function materialInvoice(): BelongsTo
    {
        return $this->belongsTo(MaterialInvoice::class, 'material_invoice_id');
    }

    public function scopeSearchByMaterialPaper($query, $search)
    {
        $search = trim((string) $search);

        return $query->when($search !== '', function ($query) use ($search) {
            $query->whereHas('material', function ($query) use ($search) {
                $query->where('paper', 'like', $search.'%');
            });
        });
    }
}
