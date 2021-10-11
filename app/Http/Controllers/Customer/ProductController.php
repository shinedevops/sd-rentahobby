<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\FavoriteRequest;
use App\Models\{Product, User, ProductFavorite};

class ProductController extends Controller
{
    /**
     * Display a product detail
     *
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $product = Product::with('category', 'images', 'locations', 'retailer', 'nonAvailableDates', 'ratings.user')->findOrFail($id);
        $averageRating = $product->ratings()->avg('rating');
        $thumbnailImage = $product->images->where('type', 'thumbnail')->pluck('file')->first();
        $galleries = $product->images->where('type', 'gallery');
        
        return view('customer.single_product', compact('product', 'thumbnailImage', 'galleries', 'averageRating'));
    }


    /**
     * Display a product detail
     *
     * @return \Illuminate\Http\Response
     */
    public function vendor(User $vendor)
    {
        return view('customer.single_vendor', compact('vendor'));
    }

    /**
     * Book the product
     *
     * @return \Illuminate\Http\Response
     */
    public function addFavorite(FavoriteRequest $request)
    {
        $product = ProductFavorite::withTrashed()->where('user_id', $request->userid)->where('product_id', $request->productid)->first();

        if ($product->count()) {
            if ($product->trashed()) {
                $product->restore();
                $message = __('favorite.messages.addProduct');
            } else {
                $product->delete();
               $message = __('favorite.messages.deleteProduct');
            }
            
            return response()->json(['title' => __('favorite.success'), 'message' => $message]);
        }
        
        ProductFavorite::insert(['product_id' => $request->productid, 'user_id' => $request->userid]);

        return response()->json(['title' => __('favorite.success'), 'message' => __('favorite.messages.addProduct')]);
    }

    /**
     * Book the product
     *
     * @return \Illuminate\Http\Response
     */
    public function book($id)
    {
        dd('Pending');
    }
}
