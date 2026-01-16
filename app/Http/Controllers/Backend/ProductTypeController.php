<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Post;

use Illuminate\Support\Arr;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Product;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        // return Carbon::now();
        $types = ProductType::with(['product'])->select([
            'product_types.id',
            'type',
            'product_id',
            'price',
            'status',
            'created_at'
        ]);
        if ($request->ajax()) {
            return Datatables::eloquent($types)
                ->addIndexColumn()
                ->addColumn('action', function ($type) {
                    return view('backend.datatable._action', [
                        'model'         => $type,
                        'delete_url'    => route('backend.product-type.destroy', $type->id),
                        'edit_url'      => route('backend.product-type.edit', $type->id),
                    ]);
                })
                ->editColumn('status', function ($type) {
                    return $type->status_label;
                })
                ->editColumn('price', function ($type) {
                    return $type->price_formated;
                })
                ->editColumn('created_at', function ($type) {
                    return $type->created_at->translatedFormat('d F Y');
                })
                ->rawColumns(['action', 'status',])
                ->make(true);
        }
        return view('backend.product-type.index');
    }



    public function create(ProductType $product_type)
    {
        $this->authorize('isAdmin', ProductType::class);
        $products = Product::all();
        return view('backend.product-type.create', compact('product_type', 'products'));
    }

    public function store(Request $request)
    {
        $this->authorize('isAdmin', ProductType::class);
        $request->validate([
            'type'   => 'required|max:255',
            'status' => 'required',
            'price'  => 'required',
        ]);

        $type = ProductType::create($request->all());
        $request->session()->flash('flash_notification', [
            "level" => "info",
            "message" => "Product " . $type->product->product . " <strong >(type : " . $type->type . ")</strong > with a price <strong>" . $type->price_formated . "</strong> has been created successfully"
        ]);
        return redirect()->back()->withInput();;
    }

    public function edit(ProductType $product_type)
    {
        $this->authorize('isAdmin', ProductType::class);
        $products = Product::all();
        return view('backend.product-type.edit', compact('product_type', 'products'));
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
        $this->authorize('isAdmin', ProductType::class);

        $type = ProductType::findOrFail($id);
        $request->validate([
            'type'   => 'required|max:255',
            'status' => 'required',
            'price'  => 'required',
        ]);

        $type->update($request->all());
        $request->session()->flash('flash_notification', [
            "level" => "info",
            "message" => "Data $type->type has been updated successfully"
        ]);
        return redirect()->route('backend.product-type.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function destroy(Request $request)
    {
        $msg = '';

        $dataId = $request->data;
        if (is_array($dataId)) {
            foreach ($dataId as $id) {
                $type = ProductType::find($id);
                if ($type) {
                    $type->destroy($id);
                }
            }
        } else {
            $type = ProductType::find($dataId);
            $type->delete();
        }

        return response()->json(['msg' => $msg]);
    }
}
