<?php

namespace App\Http\Controllers\Backend;

use App\Models\PhotoDelivery;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Cviebrock\EloquentSluggable\Services\SlugService;

class PhotoDeliveryController extends Controller
{
    private function uploadPath()
    {
        return public_path('uploads/tmp/' . auth()->user()->id); // Direct path - no symlink needed
    }

    public function index(Request $request)
    {
        $deliveries = PhotoDelivery::with('media')->paginate(12);
        return view('backend.photo-delivery.index', compact('deliveries'));
    }

    public function create(PhotoDelivery $delivery)
    {
        $this->authorize('isAdmin', PhotoDelivery::class);
        $products = Product::all();
        return view('backend.photo-delivery.create', compact('delivery', 'products'));
    }

    // public function storeMedia(Request $request)
    // {
    //     $path = $this->uploadPath();

    //     if (!file_exists($path)) {
    //         mkdir($path, 0777, true);
    //     }

    //     $file = $request->file('file');

    //     $name = trim($file->getClientOriginalName());

    //     $file->move($path, $name);

    //     return response()->json([
    //         'name'          => $name,
    //         'original_name' => $file->getClientOriginalName(),
    //     ]);
    // }

    // public function deleteMedia(Request $request)
    // {
    //     $path = $this->uploadPath();

    //     $filePath = $path . '/' . $request->filename;

    //     if (file_exists($filePath)) unlink($filePath);
    // }

    public function store(Request $request)
    {
        $this->authorize('isAdmin', PhotoDelivery::class);

        $delivery = PhotoDelivery::create($request->all());

        foreach ($request->input('images', []) as $file) {
            $delivery->addMedia($this->uploadPath() . '/' . $file)
                ->withResponsiveImages()
                ->toMediaCollection('images');
        }
        if ($request->input('images', [])) {
            $request->session()->flash('flash_notification', [
                "level" => "info",
                "message" => "Data has been created successfully"
            ]);
        }

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
