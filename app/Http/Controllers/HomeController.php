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
        // Buscando as Cidades
        $result_cidade = $home->cidade_select();
           
        return view('home', [
            'result_cidade' => $result_cidade,
            'title' => 'Relatórios Climáticos | Open Weather Map | API'
        ]);
    }
}
