<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function loginpage()
    {
        return view('login.login');
    }
}
