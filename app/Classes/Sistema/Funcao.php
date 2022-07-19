<?php

namespace App\Classes\Sistema;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Funcao extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'funcao';

    protected $fillable = [
        'id', 'nome', 'id_funcao_pai'
    ];

    protected $dates = ['deleted_at'];

    /**
     * Método que retorna os filhos de uma função separados por vírgula
     * 
     * @var array
     */
    public static function buscaFuncaoFilhos ($id) 
    {
        $filhos = array();
        $ultimos = array();
        do {
            $id = (count($ultimos) == 0) ? $id : implode(",",$ultimos); 
            $idFilhos = DB::table('funcao')->select('id')->whereRaw("find_in_set( id_funcao_pai, '".$id."') > 0")->get();
            $ultimos = array();
            foreach ($idFilhos as $item) {
                $filhos[] = $item->id;
                $ultimos[] = $item->id;
            }            
        } while (count($ultimos) > 0);
        return ((count($filhos) > 0) ? implode(',',$filhos) : 0);
    }
    
}
