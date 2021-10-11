<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnavailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'date', 'time'
    ];

    public function getDateAttribute($value)
    {
        return date(session()->get('date'), strtotime($value)); 
    }

}
