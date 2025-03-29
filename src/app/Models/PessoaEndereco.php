<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PessoaEndereco extends Pivot
{
    protected $table = 'pessoa_endereco';
    public $incrementing = false;
    public $timestamps = false;
}
