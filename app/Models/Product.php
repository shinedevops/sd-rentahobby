<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name','description','specification','category_id','user_id','quantity','rent','price','security', 'available', 'status', 'modified_user_type', 'modified_by'
    ];

    /**
     * Product retailer
     *
     * @var object
     */

    public function retailer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Product category
     *
     * @var object
     */

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Product locations
     *
     * @var object
     */

    public function locations()
    {
        return $this->hasMany(ProductLocation::class);
    }

    /**
     * Product images
     *
     * @var object
     */

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Product non available dates
     *
     * @var object
     */

    public function nonAvailableDates()
    {
        return $this->hasMany(ProductUnavailability::class)->select('date', 'product_id');
    }

    /**
     * Product ratings
     *
     * @var object
     */

    public function ratings()
    {
        return $this->hasMany(ProductRating::class);
    }
}
