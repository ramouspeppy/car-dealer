<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function uploadPath()
    {
        return public_path('upload/tmp/' . auth()->user()->id);
    }

    private function uploadRelativePath()
    {
        return 'tmp/' . auth()->user()->id . '/gallery';
    }

    public function index(Request $request)
    {
        $product = Product::with('product_category')->select([
            'products.id',
            'products.name',
            'products.product_category_id',
            'products.priority',
            'products.status',
            'products.created_at'
        ]);

        if ($request->ajax()) {
            return Datatables::eloquent($product)
                ->addIndexColumn()
                ->addColumn('action', function ($product) {
                    return view('backend.datatable._action', [
                        'model'         => $product,
                        'delete_url'    => route('backend.product.destroy', $product->id),
                        'edit_url'      => route('backend.product.edit', $product->id),
                    ]);
                })
                ->editColumn('status', function ($type) {
                    return $type->status_label;
                })
                ->editColumn('created_at', function ($product) {
                    return $product->created_at->translatedFormat('d F Y');
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('backend.product.index');
    }

    public function create(Product $product)
    {
        $this->authorize('isAdmin', Product::class);
        $product_categories = ProductCategory::all();
        return view('backend.product.create', compact('product', 'product_categories'));
    }


    public function store(ProductStoreRequest $request)
    {
        $this->authorize('isAdmin', Product::class);

        $product = Product::create($request->validated());

        $product->addMedia($request->file('image'))
            ->toMediaCollection('image');

        foreach ($request->input('product_gallery', []) as $file) {
            $product->addMedia($this->uploadPath() . '/' . $file)->toMediaCollection('product_gallery');
        }

        foreach ($request->input('product_colors', []) as $file) {
            $product->addMedia($this->uploadPath() . '/' . $file)->toMediaCollection('product_colors');
        }

        if ($request->hasFile('brochure')) {
            $product->addMedia($request->file('brochure'))
                ->toMediaCollection('brochure');
        }


        $request->session()->flash('flash_notification', [
            "level" => "info",
            "message" => "Data $product->product has been created successfully"
        ]);

        return redirect()->route('backend.product.index');
    }

    public function edit(Product $product)
    {
        $this->authorize('isAdmin', Product::class);
        $product_categories = ProductCategory::all();

        return view('backend.product.edit', compact('product', 'product_categories'));
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        $this->authorize('isAdmin', Product::class);

        $product = Product::findOrFail($id);

        $product->update($request->all());


        $this->syncMedia($product, 'product_gallery', $request->input('product_gallery', []));
        $this->syncMedia($product, 'product_colors', $request->input('product_colors', []));

        if ($request->hasFile('image')) {
            $product
                ->addMedia($request->file('image'))
                ->toMediaCollection('image');
        }

        if ($request->hasFile('brochure')) {
            $product
                ->addMedia($request->file('brochure'))
                ->toMediaCollection('brochure');
        }

        $request->session()->flash('flash_notification', [
            "level" => "info",
            "message" => "Data $product->product has been updated successfully"
        ]);
        return redirect()->route('backend.product.index');
    }


    public function destroy(Request $request, $id)
    {
        $this->authorize('isAdmin', Product::class);

        $product = Product::findOrFail($id);

        $request->session()->flash('flash_notification', [
            "level" => "info",
            "message" => "Data $product->product has been deleted successfully"
        ]);

        $product->destroy($id);

        return redirect()->route('backend.product.index');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Product::class, 'slug', $request->slug);
        return response()->json(['slug' => $slug]);
    }


    private function syncMedia(Product $product, string $collection, array $files)
    {
    // hapus media yang sudah tidak ada di input
    foreach ($product->getMedia($collection) as $media) {
        if (!in_array($media->file_name, $files)) {
            $media->delete();
        }
    }

    // muat ulang relasi media supaya yang sudah dihapus tidak ikut terhitung
    $product->unsetRelation('media');
    $existing = $product->getMedia($collection)->pluck('file_name')->toArray();

    // tambah file baru dari folder temp
    foreach ($files as $file) {
        if (!in_array($file, $existing)) {
            $product->addMedia($this->uploadPath() . '/' . basename($file))
                ->toMediaCollection($collection);
        }
    }
}
}
