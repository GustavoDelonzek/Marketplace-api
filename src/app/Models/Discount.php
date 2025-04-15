<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'start_date',
        'end_date',
        'product_id',
        'discount_percentage',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function product():BelongsTo
    {
        return $this->BelongsTo(Product::class);
    }
}
