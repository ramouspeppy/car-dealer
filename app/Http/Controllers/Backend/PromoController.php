<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Post;

use Illuminate\Support\Arr;
use App\Models\Promo;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        // return Carbon::now();
        $promo = Promo::select([
            'id',
            'promo',
            'priority',
            'effective_date',
            'status',
            'created_at'
        ]);
        if ($request->ajax()) {
            return Datatables::eloquent($promo)
                ->addIndexColumn()
                ->addColumn('action', function ($promo) {
                    return view('backend.datatable._action', [
                        'model'         => $promo,
                        'delete_url'    => route('backend.promo.destroy', $promo->id),
                        'edit_url'      => route('backend.promo.edit', $promo->id),
                    ]);
                })
                ->editColumn('created_at', function ($promo) {
                    return $promo->created_at->translatedFormat('d F Y');
                })
                ->editColumn('effective_date', function ($promo) {
                    return $promo->effective_date->translatedFormat('d F Y');
                })
                ->addColumn('effective_label', function ($promo) {
                    return $promo->effective_label;
                })
                ->editColumn('status', function ($type) {
                    return $type->status_label;
                })
                ->rawColumns(['action', 'status', 'effective_label'])
                ->make(true);
        }
        return view('backend.promo.index');
    }



    public function create(Promo $promo)
    {
        $this->authorize('isAdmin', Promo::class);
        return view('backend.promo.create', compact('promo'));
    }

    public function store(Request $request)
    {
        $this->authorize('isAdmin', Promo::class);
        $request->validate([
            'promo' => 'required|unique:promos|max:255',
            'status'   => 'required',
            'link'   => 'nullable|url',
            'effective_date' => 'required|date',
            'promo_image'   => 'required|image|file|max:2048'
        ]);

        $promo = Promo::create($request->all());

        if ($request->hasFile('promo_image')) {
            $promo
                ->addMedia($request->promo_image)
                ->toMediaCollection('promo_image');
        }
        $request->session()->flash('flash_notification', [
            "level" => "info",
            "message" => "Data $promo->title has been created successfully"
        ]);
        return redirect()->route('backend.promo.index');
    }

    public function edit(Promo $promo)
    {
        $this->authorize('isAdmin', Promo::class);

        return view('backend.promo.edit', compact('promo'));
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
        $this->authorize('isAdmin', Promo::class);

        $promo = Promo::findOrFail($id);
        $request->validate([
            'promo' => 'required|unique:promos,promo,' . $id,
            'status'   => 'required',
            'link'   => 'url',
            'promo_image'   => 'image|file|max:2048',
        ]);

        $promo->update($request->all());

        if ($request->hasFile('promo_image')) {
            $promo
                ->addMedia($request->promo_image)
                ->toMediaCollection('promo_image');
        }

        $request->session()->flash('flash_notification', [
            "level" => "info",
            "message" => "Data $promo->title has been updated successfully"
        ]);
        return redirect()->route('backend.promo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request, $id)
    {
        $this->authorize('isAdmin', Promo::class);

        $promo = Promo::findOrFail($id);

        $request->session()->flash('flash_notification', [
            "level" => "info",
            "message" => "Data $promo->promo has been deleted successfully"
        ]);

        $promo->destroy($id);

        return redirect()->route('backend.promo.index');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Promo::class, 'slug', $request->slug);
        return response()->json(['slug' => $slug]);
    }
}
