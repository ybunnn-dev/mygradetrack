<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MetricsController extends Controller
{
    /**
     * Display the metrics dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('metrics');
    }
}