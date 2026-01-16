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
        $path = $this->uploadRelativePath();
        $file = $request->file('file');

        $basename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $ext = $file->getClientOriginalExtension();
        $name = uniqid() . '_' . Str::slug($basename) . '.' . $ext;

        Storage::putFileAs($path, $file, $name);

        return response()->json([
            'name'          => $name,
            'url'           => Storage::url("$path/$name"),
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function destroy(Request $request)
    {
        $path = $this->uploadRelativePath() . '/' . $request->filename;
        Storage::disk('public')->delete($path);
        return response()->noContent();
    }

    private function uploadRelativePath()
    {
        return "tmp/" . auth()->id();
    }
}
