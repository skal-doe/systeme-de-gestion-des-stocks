<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use App\Models\Supplier;
use App\Enums\MovementTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'product_id',
        'quantity',
        'user_id',
        'supplier_id',
        'reference',
        'date',
        'notes',
    ];

    protected $casts = [
        'date' => 'datetime',
        'type' => MovementTypeEnum::class,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function isEntryMovement()
    {
        return $this->type === MovementTypeEnum::IN;
    }

    public function isExitMovement()
    {
        return $this->type === MovementTypeEnum::OUT;
    }
}
