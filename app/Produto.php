<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';
    protected $fillable = ['nome','descricao','valor','url_imagem']; //passar os campos que serão preenchidos
}
