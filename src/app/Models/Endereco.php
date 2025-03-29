<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'endereco';
    protected $primaryKey = 'end_id';
    public $timestamps = false;

    protected $fillable = [
        'end_tipo_logradouro', 'end_logradouro', 'end_numero', 'end_bairro', 'cid_id'
    ];

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cid_id', 'cid_id');
    }
}
