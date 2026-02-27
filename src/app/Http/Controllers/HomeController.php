<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function welcome()
    {
        if (auth()->check()) {
            return redirect('/home');
        }
        return view('welcome');
    }

    public function index()
    {
        if (!auth()->check()) {
            return redirect('/');
        }
        return view('home');
    }

}
