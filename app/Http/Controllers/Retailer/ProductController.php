<?php

namespace App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\{Category, Product, ProductImage, ProductLocation, ProductUnavailability};
use File, Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id', 'DESC')->where('user_id', auth()->user()->id)->paginate(Session::get('pagination'));
        
        return view('retailer.list_product', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', 'Active')->get();

        return view('retailer.add_product', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest  $request)
    {
        $userId = auth()->user()->id;
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category,
            'user_id' => auth()->user()->id,
            'quantity' => $request->quantity,
            'rent' => $request->rent,
            'price' => $request->price,
            'security' => $request->security,
            'available' => $request->quantity,
            'status' => isset($request->status) ? 'Active' : 'Inactive'
        ];

        $product = Product::create($data);
        $thumbnailImage = $request->file('thumbnail_image');
        $fileName = time() . '-'. rand(1111, 9999) . '-user-'. $userId."." . $thumbnailImage->getClientOriginalExtension();
        $filePath = $thumbnailImage->storeAs('product', $fileName);
        $productMeta[] = [
            'product_id' => $product->id,
            'file' => $filePath,
            'type' => 'thumbnail'        
        ];

        if ($request->hasFile('gallery_image')) {
            foreach($request->file('gallery_image') as $file) {
                $fileName = time() . '-'. rand(1111, 9999) . '-user-'. $userId."." . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('product', $fileName);

                $productMeta[] = [
                    'product_id' => $product->id,
                    'file' => $filePath,
                    'type' => 'gallery'
                ];
            }
        }

        ProductImage::insert($productMeta);

        if ($request->has('location')) {
            $locationData = [];
            foreach($request->location as $location) {
                $locationData[] = [
                    'product_id' => $product->id,
                    'country_id' => auth()->user()->country_id,
                    'state_id' => auth()->user()->state_id,
                    'city_id' => auth()->user()->city_id,
                    'postcode' => auth()->user()->postcode,
                    'address' => $location
                ];
            }
            if (count($locationData)) {
                ProductLocation::insert($locationData);
            }
        }

        if ($request->has('non_availabile_dates') && !empty($request->non_availabile_dates)) {
            $nonAvailableDatesArray = explode(',', $request->non_availabile_dates);
            $nonAvailableDates = [];
            foreach($nonAvailableDatesArray as $singleNonAvailableDate) {
                $nonAvailableDates[] = [
                    'product_id' => $product->id,
                    'date' => date('Y-m-d', strtotime($singleNonAvailableDate)),
                ];
            }
            if (count($nonAvailableDates)) {
                ProductUnavailability::insert($nonAvailableDates);
            }
        }

        return redirect()->route('retailer.products')->with('success', __('product.messages.saveProduct'));;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with('locations', 'nonAvailableDates')->findOrFail($id);
        $categories = Category::where('status', 'Active')->get();
        $nonAvailableDates = $product->nonAvailableDates->pluck('date')->toArray();
        
        return view('retailer.edit_product', compact('product', 'categories', 'nonAvailableDates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $userId = auth()->user()->id;
        $productId = $product->id;
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category,
            'user_id' => auth()->user()->id,
            'quantity' => $request->quantity,
            'rent' => $request->rent,
            'price' => $request->price,
            'security' => $request->security,
            'available' => $request->quantity,
            'location' => $request->location,
            'status' => isset($request->status) ? 'Active' : 'Inactive',
            'modified_user_type' => 'Self',
            'modified_by' => auth()->user()->id,
        ];
        
        if ('Active' == $data['status'] && 'Admin' == $product->modified_user_type) {
            unset($data['status']);
            unset($data['modified_user_type']);
            unset($data['modified_by']);
        }
        
        $update = Product::where('id', $productId)->where('user_id', $userId)->update($data);

        if ($update && ($request->hasFile('gallery_image') || $request->hasFile('thumbnail_image'))) {
            // update the thumbnail image
            if ($request->hasFile('thumbnail_image')) {
                $thumbnailImage = $request->file('thumbnail_image');
                $fileName = time() . '-'. rand(1111, 9999) . '-user-'. $userId."." . $thumbnailImage->getClientOriginalExtension();
                $filePath = $thumbnailImage->storeAs('product', $fileName);
                ProductImage::where('product_id', $productId)->where('type', 'thumbnail')->update(['file' => $filePath]);
            } 

            if ($request->hasFile('gallery_image')) {
                // remove the previous gallery image and add the new one
                $galleryImages = ProductImage::where('product_id', $productId)->where('type', 'gallery')->get();
                foreach($galleryImages as $galleryImage) {
                    $path = storage_path().'/app/'.$galleryImage->file;
                    if(File::exists($path)) {
                        unlink($path);
                    }
                }
                
                ProductImage::where('product_id', $productId)->where('type', 'gallery')->delete();
                foreach($request->file('gallery_image') as $file) {
                    $fileName = time() . '-'. rand(1111, 9999) . '-user-'. $userId."." . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('product', $fileName);
    
                    $productMeta[] = [
                        'product_id' => $productId,
                        'file' => $filePath,
                        'type' => 'gallery'
                    ];
                }

                ProductImage::insert($productMeta);
            }
        }

        if ($request->has('location')) {
            $locationData = [];
            foreach($request->location as $location) {
                $locationData[] = [
                    'product_id' => $productId,
                    'country_id' => auth()->user()->country_id,
                    'state_id' => auth()->user()->state_id,
                    'city_id' => auth()->user()->city_id,
                    'postcode' => auth()->user()->postcode,
                    'address' => $location
                ];
            }

            if (count($locationData)) {
                ProductLocation::where('product_id', $productId)->delete();
                ProductLocation::insert($locationData);
            }
        }

        if ($request->has('non_availabile_dates') && !empty($request->non_availabile_dates)) {
            $nonAvailableDatesArray = explode(',', $request->non_availabile_dates);
            $nonAvailableDates = [];
            foreach($nonAvailableDatesArray as $singleNonAvailableDate) {
                $nonAvailableDates[] = [
                    'product_id' => $product->id,
                    'date' => date('Y-m-d', strtotime($singleNonAvailableDate)),
                ];
            }
            if (count($nonAvailableDates)) {
                ProductUnavailability::insert($nonAvailableDates);
            }
        }

        return redirect()->route('retailer.products')->with('success', __('product.messages.updateProduct'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::where('id', $id)->delete();

        return redirect()->route('retailer.products')->with('success', __('product.messages.deleteProduct'));
    }
}
