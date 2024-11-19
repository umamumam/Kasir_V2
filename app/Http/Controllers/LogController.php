<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = Log::query();

        $startDate = $request->input('start_date', Carbon::today()->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->toDateString());

        $query->whereBetween('created_at', [
            $startDate . ' 00:00:00',
            $endDate . ' 23:59:59',
        ]);

        $logs = $query->paginate(10);

        return view('logs.index', compact('logs', 'startDate', 'endDate'));
    }
}

