<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function index()
    {
        $items = DB::table('YOUR_VIEW_NAME')->get();

        return view('data.index', compact('items'));
    }
}
