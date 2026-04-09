<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ToolController extends Controller
{
    public function valuations(): View
    {
        return view('pages.tools.valuations');
    }

    public function buyingGuide(): View
    {
        return view('pages.tools.buying-guide');
    }
}
