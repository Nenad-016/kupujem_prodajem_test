<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdReport;
use Illuminate\Http\Request;

class AdminAdReportController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');

        $query = AdReport::with(['ad', 'user'])->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $reports = $query->paginate(20);

        return view('admin.ad_reports.index', compact('reports', 'status'));
    }

    public function updateStatus(Request $request, AdReport $report)
    {
        $request->validate([
            'status' => ['required', 'in:pending,reviewed,dismissed'],
        ]);

        $report->update([
            'status' => $request->input('status'),
        ]);

        return back()->with('success', 'Status prijave je uspešno ažuriran.');
    }
}
