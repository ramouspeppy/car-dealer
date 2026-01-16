<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Post;

use Illuminate\Support\Arr;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Product;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        // return Carbon::now();
        $categories = ProductCategory::with(['products'])->select([
            'product_categories.id',
            'category',
            'priority',
            'status',
            'created_at'
        ])->withCount('products');
        if ($request->ajax()) {
            return Datatables::eloquent($categories)
                ->addIndexColumn()
                ->addColumn('action', function ($category) {
                    return view('backend.datatable._actionProtectedID', [
                        'model'         => $category,
                        'delete_url'    => route('backend.product-category.destroy', $category->id),
                        'edit_url'      => route('backend.product-category.edit', $category->id),
                    ]);
                })
                ->editColumn('created_at', function ($category) {
                    return $category->created_at->translatedFormat('d F Y');
                })
                ->editColumn('status', function ($type) {
                    return $type->status_label;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('backend.product-category.index');
    }



    public function create(ProductCategory $product_category)
    {
        $this->authorize('isAdmin', ProductCategory::class);
        return view('backend.product-category.create', compact('product_category'));
    }

    public function store(Request $request)
    {
        $this->authorize('isAdmin', ProductCategory::class);
        $request->validate([
            'category' => 'required|unique:product_categories|max:255',
            'priority' => 'required|numeric',
            'status'   => 'required',
        ]);

        $category = ProductCategory::create($request->all());
        $request->session()->flash('flash_notification', [
            "level" => "info",
            "message" => "Data $category->title has been created successfully"
        ]);
        return redirect()->route('backend.product-category.index');
    }

    public function edit(ProductCategory $product_category)
    {
        $this->authorize('isAdmin', ProductCategory::class);

        return view('backend.product-category.edit', compact('product_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin', ProductCategory::class);

        $category = ProductCategory::findOrFail($id);
        $request->validate([
            'category' => 'required|unique:product_categories,category,' . $id,
            'priority' => 'required|numeric',
            'status'   => 'required',
        ]);

        $category->update($request->all());
        $request->session()->flash('flash_notification', [
            "level" => "info",
            "message" => "Data $category->title has been updated successfully"
        ]);
        return redirect()->route('backend.product-category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request, $id)
    {
        $this->authorize('isAdmin', ProductCategory::class);

        $category = ProductCategory::findOrFail($id);

        if ($id == 1) {
            $request->session()->flash('flash_notification', [
                "level" => "danger",
                "message" => "$category->category cannot be deleted"
            ]);
            return redirect()->back();
        }

        Product::where('product_category_id', $id)->update(['product_category_id' => 1]);
        $category = ProductCategory::findOrFail($id);

        $request->session()->flash('flash_notification', [
            "level" => "info",
            "message" => "Data $category->title has been deleted successfully"
        ]);
        $category->destroy($id);

        return redirect()->route('backend.product-category.index');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(ProductCategory::class, 'slug', $request->slug);
        return response()->json(['slug' => $slug]);
    }
}
