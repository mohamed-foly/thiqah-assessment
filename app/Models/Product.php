<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'slug',
        'is_active',
    ];


    public function getPriceAttribute($value)
    {
        switch (auth()->user()->type) {
            case UserType::Silver->value:
                $discount = 0.10;
                break;
            case UserType::Gold->value:
                $discount = 0.20;
                break;

            default:
                $discount = 0;
                break;
        }
        $discountedPrice = $value - ($value * $discount);

        return number_format($discountedPrice, 2); // Format the price with 2 decimal places
    }
}
