<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UnidadeEndereco extends Pivot
{
    protected $table = 'unidade_endereco';
    public $incrementing = false;
    public $timestamps = false;
}
