<?php

namespace App\Http\Controllers\Backend;

use App\Models\Testdrive;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class TestdriveController extends Controller
{
    public function index(Request $request)
    {
        $testdrive = Testdrive::select([
            'testdrives.id',
            'testdrives.name',
            'testdrives.wa',
            'testdrives.schedule_date',
            'testdrives.product',
            'testdrives.status',
            'testdrives.created_at'
        ]);

        if ($request->ajax()) {
            return Datatables::eloquent($testdrive)
                ->addIndexColumn()
                ->addColumn('action', function ($testdrive) {
                    return view('backend.datatable._actionRead', [
                        'read_url'    => route('backend.testdrive.read', $testdrive->id),
                    ]);
                })
                ->editColumn('wa', function ($testdrive) {
                    return $testdrive->wa_button;
                })
                ->editColumn('status', function ($testdrive) {
                    return $testdrive->statusLabel;
                })
                ->editColumn('created_at', function ($testdrive) {
                    return $testdrive->created_at->translatedFormat('d F Y');
                })
                ->rawColumns(['action', 'status', 'wa'])
                ->make(true);
        }
        return view('backend.testdrive.index');
    }

    public function read(Testdrive $testdrive)
    {
        $testdrive->update(['status' => 1]);

        $this->authorize('isAdmin', Testdrive::class);
        return view('backend.testdrive.read', compact('testdrive'));
    }
}
