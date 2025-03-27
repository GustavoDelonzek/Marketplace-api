<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'code',
        'start_date',
        'end_date',
        'discount_percentage'
    ];

    public function orders():BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    
}
