<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('cekUserLogin');
    // }
    
    public function index()
    {
        return view('maindashboard')->with([
            'user' => Auth::guard('pegawai')->user(),
        ]);
    }
}