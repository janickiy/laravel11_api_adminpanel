<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.index')->with('title', '');
    }
}
