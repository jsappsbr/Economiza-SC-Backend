<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'name',
        'price',
        'picture',
        'link',
        'sku',
    ];

    protected $casts = [
        'price' => 'double',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Market::class);
    }
}
