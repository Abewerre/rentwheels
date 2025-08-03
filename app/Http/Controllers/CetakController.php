<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CetakController extends Controller
{
    public function index()
    {
        return view('cetak.index');
    }
} 