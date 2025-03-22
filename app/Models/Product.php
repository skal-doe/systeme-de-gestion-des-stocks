<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'sku',
        'price',
        'quantity',
        'alert_level',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }

    public function increaseStock($quantity)
    {
        $this->quantity += $quantity;
        $this->save();

        return $this;
    }

    public function decreaseStock($quantity)
    {
        if ($this->quantity >= $quantity) {
            $this->quantity -= $quantity;
            $this->save();

            return true;
        }

        return false;
    }

    public function isLowStock()
    {
        return $this->quantity <= $this->alert_level;
    }
}
