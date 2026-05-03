<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ImagesUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $path = public_path('uploads/tmp/' . auth()->id());

        // pastikan folder ada
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $basename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $ext = $file->getClientOriginalExtension();
        $name = uniqid() . '_' . Str::slug($basename) . '.' . $ext;

        // ✅ simpan langsung ke public
        $file->move($path, $name);

        return response()->json([
            'name' => $name,
            'url'  => asset("uploads/tmp/" . auth()->id() . "/" . $name),
        ]);
    }

    public function destroy(Request $request)
    {
        $path = public_path('uploads/tmp/' . auth()->id() . '/' . $request->filename);

        if (file_exists($path)) {
            unlink($path);
        }

        return response()->noContent();
    }

    private function uploadRelativePath()
    {
        // ✅ FIX: jangan pakai public_path()
        return 'uploads/tmp/' . auth()->id();
    }
}
