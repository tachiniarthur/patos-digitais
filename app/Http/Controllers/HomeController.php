<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home');
    }
}