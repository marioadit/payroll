<?php

namespace App\Http\Controllers;

use App\Models\logbook;
use Illuminate\Http\Request;

class logbookController extends Controller
{
    /**
     * Display a filtered listing of logbook records by month and year.
     *
     * @param  Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Retrieve the selected month and year from the request
        $month = $request->get('month', date('m')); // Default to the current month
        $year = $request->get('year', date('Y'));  // Default to the current year

        // Fetch logbook records filtered by the selected month and year
        $logbookRecords = logbook::whereYear('tgl_byr', $year)
            ->whereMonth('tgl_byr', $month)
            ->orderBy('tgl_byr', 'desc')
            ->get();

        // Pass the data and selected values to the view
        return view('logbook', compact('logbookRecords', 'month', 'year'));
    }
}
