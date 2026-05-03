<?php

namespace App\Http\Controllers\Backend;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $consultation = Consultation::with('product')->select([
            'id',
            'name',
            'phone',
            'product_id',
            'payment_type',
            'status',
            'created_at'
        ]);

        if ($request->ajax()) {
            return Datatables::eloquent($consultation)
                ->addIndexColumn()
                ->addColumn('action', function ($consultation) {
                    return view('backend.datatable._actionShow', [
                        'show_url'    => route('backend.consultation.show', $consultation->id),
                    ]);
                })
                ->editColumn('phone', function ($consultation) {
                    return $consultation->wa_button;
                })
                ->editColumn('status', function ($consultation) {
                    return $consultation->statusLabel;
                })
                ->editColumn('created_at', function ($consultation) {
                    return $consultation->created_at->translatedFormat('d F Y');
                })
                ->rawColumns(['action', 'status', 'phone'])
                ->make(true);
        }
        return view('backend.consultation.index');
    }

    public function show(Consultation $consultation)
    {

        $this->authorize('isAdmin', Consultation::class);
        return view('backend.consultation.show', compact('consultation'));
    }
    public function contact(Consultation $consultation)
    {
        $this->authorize('isAdmin', Consultation::class);

        if ($consultation->status == 'new') {
            $consultation->update(['status' => 'contacted']);
        }

        return redirect()->to($consultation->wa_url($consultation->phone_formatted));
    }
    public function updateStatus(Consultation $consultation, Request $request)
    {
        $consultation->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'status'  => $consultation->status,
            'message' => 'Status berhasil diubah ke ' . ucfirst($consultation->status),
        ]);
    }
}
