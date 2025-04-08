<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    protected $hidden = [
        'deleted_at',
    ];

    public function orders():HasMany
    {
        return $this->hasMany(Order::class);
    }


}
