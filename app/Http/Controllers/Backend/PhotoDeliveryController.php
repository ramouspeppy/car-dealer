<?php

namespace App\Http\Controllers\Backend;

use App\Models\PhotoDelivery;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PhotoDeliveryController extends Controller
{
    private function uploadPath()
    {
        return public_path('upload/tmp/' . auth()->id());
    }

    public function index(Request $request)
    {
        $filters = $request->validate([
            'product_id' => ['nullable', 'integer', 'exists:products,id'],
        ]);

        $products = Product::query()
            ->select(['id', 'name'])
            ->withCount('photo_delivery')
            ->orderBy('name')
            ->get();
        $selectedProductId = $filters['product_id'] ?? null;

        $deliveriesQuery = PhotoDelivery::with(['media', 'product'])
            ->whereHas('media', function ($query) {
                $query->where('collection_name', 'images');
            });
        if ($selectedProductId) {
            $deliveriesQuery->where('product_id', $selectedProductId);
        }

        $photoCount = Media::query()
            ->where('model_type', (new PhotoDelivery())->getMorphClass())
            ->where('collection_name', 'images')
            ->whereIn('model_id', (clone $deliveriesQuery)->select('id'))
            ->count();

        $deliveries = $deliveriesQuery->latest()->paginate(12)->appends($request->only('product_id'));

        return view('backend.photo-delivery.index', compact('deliveries', 'products', 'selectedProductId', 'photoCount'));
    }

    public function create(PhotoDelivery $delivery)
    {
        $this->authorize('isAdmin', PhotoDelivery::class);
        $products = Product::all();
        return view('backend.photo-delivery.create', compact('delivery', 'products'));
    }

    public function storeMedia(Request $request)
    {
        $this->authorize('isAdmin', PhotoDelivery::class);

        $request->validate([
            'file' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $file = $request->file('file');
        $basename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = strtolower($file->getClientOriginalExtension());
        $name = Str::uuid() . '_' . Str::slug($basename) . '.' . $extension;

        $file->storeAs('tmp/' . auth()->id(), $name, 'photo_delivery');

        return response()->json([
            'name' => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function deleteMedia(Request $request)
    {
        $this->authorize('isAdmin', PhotoDelivery::class);

        $validated = $request->validate([
            'filename' => ['required', 'string', 'regex:/\A[a-zA-Z0-9_-]+\.(?:jpg|jpeg|png|webp)\z/i'],
        ]);

        Storage::disk('photo_delivery')->delete('tmp/' . auth()->id() . '/' . $validated['filename']);

        return response()->noContent();
    }

    public function store(Request $request)
    {
        $this->authorize('isAdmin', PhotoDelivery::class);

        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'string', 'regex:/\A[a-zA-Z0-9_-]+\.(?:jpg|jpeg|png|webp)\z/i'],
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['images'] as $file) {
                $delivery = PhotoDelivery::create([
                    'product_id' => $validated['product_id'],
                ]);

                $delivery->addMedia($this->uploadPath() . DIRECTORY_SEPARATOR . $file)
                    ->withResponsiveImages()
                    ->toMediaCollection('images');
            }
        });

        $request->session()->flash('flash_notification', [
            "level" => "info",
            "message" => count($validated['images']) . " photo delivery image(s) has been created successfully"
        ]);

        return redirect()->route('backend.photo-delivery.index');
    }

    public function destroy(Request $request)
    {
        $dataId = $request->data;

        $msg = '';

        if (is_array($dataId)) {
            foreach ($dataId as $id) {
                $post = PhotoDelivery::find($id);
                $post->destroy($id);
            }
        } else {
            $post = PhotoDelivery::findOrFail($dataId);
            $post->destroy($dataId);
        }

        return response()->json(['msg' => $msg]);
    }
}
