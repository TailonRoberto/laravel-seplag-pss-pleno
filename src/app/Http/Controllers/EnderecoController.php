<?php

namespace App\Http\Controllers;

use App\Models\Endereco;

class EnderecoController extends Controller
{
    public function index()
    {
        return Endereco::with('cidade')->paginate(10); 
    }
}