<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\ProductCategory;
use Cviebrock\EloquentSluggable\Services\SlugService;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function uploadPath()
    {
        return public_path('uploads/tmp/' . auth()->user()->id); // Direct path - no symlink needed
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

        $product = Product::create($request->all());

        $product->addMedia($request->file('header_image'))
            ->toMediaCollection('header_image');

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


        if (count($product->product_gallery) > 0) {
            foreach ($product->product_gallery as $media) {
                if (!in_array($media->file_name, $request->input('product_gallery', []))) {
                    $media->delete();
                }
            }
        }

        $media = $product->product_gallery->pluck('file_name')->toArray();

        foreach ($request->input('product_gallery', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $product->addMedia($this->uploadPath() . '/' . $file)->toMediaCollection('product_gallery');
            }
        }

        $media2 = $product->product_colors->pluck('file_name')->toArray();

        foreach ($request->input('product_colors', []) as $file) {
            if (count($media2) === 0 || !in_array($file, $media2)) {
                $product->addMedia($this->uploadPath() . '/' . $file)->toMediaCollection('product_colors');
            }
        }

        if ($request->hasFile('header_image')) {
            $product
                ->addMedia($request->file('header_image'))
                ->toMediaCollection('header_image');
        }

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


    // private function uploadPath()
    // {
    //     return storage_path('app/tmp/' . auth()->user()->id . '/product/galleries');
    // }

    public function storeMedia(Request $request)
    {
        $path = $this->uploadPath();

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        // $name = uniqid() . '_' . trim($file->getClientOriginalName());
        $name = trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function deleteMedia(Request $request)
    {
        $path = $this->uploadPath();

        $filePath = $path . '/' . $request->filename;

        if (file_exists($filePath)) unlink($filePath);
    }
    // =========================================================


    public function storeMedia2(Request $request)
    {
        $path = $this->uploadPath();

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        // $name = uniqid() . '_' . trim($file->getClientOriginalName());
        $name = trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function deleteMedia2(Request $request)
    {
        $path = $this->uploadPath();

        $filePath = $path . '/' . $request->filename;

        if (file_exists($filePath)) unlink($filePath);
    }
}
