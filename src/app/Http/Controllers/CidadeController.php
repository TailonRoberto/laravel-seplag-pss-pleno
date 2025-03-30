<?php

namespace App\Http\Controllers;

use App\Models\Cidade;

class CidadeController extends Controller
{
    public function index()
    {
        return Cidade::paginate(10); 
    }
}
