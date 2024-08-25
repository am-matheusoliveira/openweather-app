<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Home extends Model
{
    use HasFactory;
    
    # BUSCA: cidade
    public function cidade_select()
    {
        $result_cidade = DB::table('cidade')->select('id', 'name', 'country')->get();
        //
        return $result_cidade;
    }
}