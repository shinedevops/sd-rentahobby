<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Models\{Category, Product};
use Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::withCount('products')->paginate(Session::get('pagination'));
        
        return view('admin.list_category', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.add_category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest  $request)
    {
        $data = [
            'name' => $request->name,
            'status' => $request->status ?? 'Inactive'
        ];
        
        Category::create($data);

        return redirect()->route('admin.categories')->with('success', __('category.messages.saveCategory'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('admin.view_category', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.edit_category', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoryRequest $request, $id)
    {
        $data = [
            'name' => $request->name,
            'status' => $request->status ?? 'Inactive'
        ];
        
        Category::where('id', $id)->update($data);

        return redirect()->route('admin.categories')->with('success', __('category.messages.updateCategory'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::where('id', $id)->delete();

        return redirect()->route('admin.categories')->with('success', __('category.messages.deleteCategory'));
    }

    /**
     * Products of the specified category from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function products($id)
    {
        $products = Product::with('retailer', 'category')->where('category_id', $id)->paginate(10);
        
        return view('admin.category_product', compact('products'));
    }

    /**
     * Edit category product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editProduct($id, $pid)
    {
        $product = Product::with('retailer', 'category', 'locations')->where('category_id', $id)->findOrFail($pid);
        $categories = Category::where('status', 'Active')->get();
        
        return view('admin.edit_category_product', compact('product', 'categories'));
    }

    /**
     * Update category product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProduct(Request $request, $category_id, Product $product)
    {
        if ($product->where('category_id', $category_id)->count()) {
            $status = isset($request->status) ? 'Active' : 'Inactive';
            if ($product->status != $status) {
                $product->status = $status;
                $product->modified_user_type = 'Admin';
                $product->modified_by = auth()->user()->id;
                $product->save();
            }

            return redirect()->route('admin.categoryproduct', $category_id)->with('success', __('product.messages.updateProduct'));
        }

        return redirect()->route('admin.categoryproduct', $category_id);
    }
}
