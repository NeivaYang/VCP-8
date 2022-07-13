<?php

namespace App\Classes\Sistema;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipamento extends Model
{
    protected $table = 'equipamentos';

    use HasFactory;
    use SoftDeletes;
    protected $dates =  ['deleted_at'];
    protected $fillable = ['id', 'id_fazenda', 'nome', 'fabricante', 'noserie_painel', 'modelo', 'tipo_equipamento',
                          'altura', 'balanco', 'painel', 'giro', 'raio_ultima_torre', 'area', 'lamina_100'  
    ];
}
