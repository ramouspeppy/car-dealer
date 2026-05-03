<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;

use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        // return Carbon::now();
        $service = Service::select([
            'id',
            'title',
            'icon',
            'priority',
            'created_at'
        ]);
        if ($request->ajax()) {
            return Datatables::eloquent($service)
                ->addIndexColumn()
                ->addColumn('action', function ($service) {
                    return view('backend.datatable._action', [
                        'model'         => $service,
                        'delete_url'    => route('backend.service.destroy', $service->id),
                        'edit_url'      => route('backend.service.edit', $service->id),
                    ]);
                })
                ->editColumn('created_at', function ($service) {
                    if ($service->created_at) {
                        return $service->created_at->translatedFormat('d F Y');
                    }
                    return "-";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.service.index');
    }



    public function create(Service $service)
    {
        $this->authorize('isAdmin', Service::class);
        return view('backend.service.create', compact('service'));
    }

    public function store(Request $request)
    {
        $this->authorize('isAdmin', Service::class);
        $request->validate([
            'title'    => 'required|unique:services|max:255',
            'icon'     => 'required',
            'priority' => 'nullable|numeric',
            'desc'     => 'required'
        ]);

        $service = Service::create($request->all());

        $request->session()->flash('flash_notification', [
            "level" => "info",
            "message" => "Data $service->title has been created successfully"
        ]);
        return redirect()->route('backend.service.index');
    }

    public function edit(Service $service)
    {
        $this->authorize('isAdmin', Service::class);

        return view('backend.service.edit', compact('service'));
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
        $this->authorize('isAdmin', Service::class);

        $service = Service::findOrFail($id);
        $request->validate([
            'title'    => 'required|max:255|unique:services,title,' . $id,
            'icon'     => 'required',
            'priority' => 'nullable|numeric',
            'desc'     => 'required'
        ]);

        $service->update($request->all());

        $request->session()->flash('flash_notification', [
            "level" => "info",
            "message" => "Data $service->title has been updated successfully"
        ]);
        return redirect()->route('backend.service.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request, $id)
    {
        $this->authorize('isAdmin', Service::class);

        $service = Service::findOrFail($id);

        $request->session()->flash('flash_notification', [
            "level" => "info",
            "message" => "Data $service->service has been deleted successfully"
        ]);

        $service->destroy($id);

        return redirect()->route('backend.service.index');
    }
}
