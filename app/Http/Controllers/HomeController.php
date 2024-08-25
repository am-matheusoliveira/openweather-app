<?php

namespace App\Http\Controllers;
use App\Models\Home;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {   
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */    
    public function index(Home $home)
    {   
        // Buscando os Cidades
        $result_cidade = $home->cidade_select();

        return view('home', compact('result_cidade'));
    } 
}
