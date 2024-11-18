<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        // Ambil semua log, urutkan berdasarkan waktu terbaru
        $logs = Log::latest()->get();

        // Kirim data logs ke view
        return view('logs.index', compact('logs'));
    }
}
