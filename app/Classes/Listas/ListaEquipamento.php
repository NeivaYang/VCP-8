<?php

namespace app\Classes\Listas;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaEquipamento extends Model
{
    use HasFactory;

    public static function getModeloPivo() 
    {
        $modelos = [
            ['modelo' => '8000']
        ];
        return $modelos; 
    }

    
    public static function getFabricante()
    {
        $fabricante = [['x'], ['y'], ['z']];

        return $fabricante;
    }

    public static function geNoserie()
    {
        $noserie_painel = [[], [], []];

        return $noserie_painel;
    }

    public static function getTipoEquipamento()
    {
        $tipoEquipamento = [
            ['tipo_equipamento' => 'pivo_central'],
            ['tipo_equipamento' => 'rebocavel'],
            ['tipo_equipamento' => 'linear']
        ];
        
        return $tipoEquipamento;
    }

    public static function getListaAlturaTipo() 
    {
        $alturaTipo = [
            ['altura' => 'standard', 'altura_equipamento' => '2,74m', 'tipo' => 'linear'], 
            ['altura' => 'standard', 'altura_equipamento' => '2,74m', 'tipo' => 'rebocavel'], 
            ['altura' => 'standard', 'altura_equipamento' => '2,74m', 'tipo' => 'pivo_central'], 
            ['altura' => 'alto', 'altura_equipamento' => '3,75m', 'tipo' => 'linear'],
            ['altura' => 'alto', 'altura_equipamento' => '3,75m', 'tipo' => 'rebocavel'],
            ['altura' => 'alto', 'altura_equipamento' => '3,75m', 'tipo' => 'pivo_central'],
            ['altura' => 'extra_alto', 'altura_equipamento' => '4,60m', 'tipo' => 'pivo_central'],
            ['altura' => 'super_alto', 'altura_equipamento' => '5,50m', 'tipo' => 'pivo_central']
        ];
        return $alturaTipo;
    }

    public static function getListaAlturaEquipamento()
    {
        $tipoEquipamento = [
            ['altura_equipamento' => 'standard', 'altura' => '2,74m'], 
            ['altura_equipamento' => 'alto', 'altura' => '3,75m'],
            ['altura_equipamento' => 'extra_alto', 'altura' => '4,60m'],
            ['altura_equipamento' => 'super_alto', 'altura' => '5,50m']
        ];
        return $tipoEquipamento;
    }

    public static function getAlturaValor($altura_equipamento)
    {
        $lista = self::getListaAlturaEquipamento();
        $altura_valor = 0;
        for ($i = 0; $i < count($lista); $i++) {
            if($lista[$i]['altura_equipamento'] == $altura_equipamento) {
                $altura_valor = (Double)(str_replace(',', '.', $lista[$i]['altura']));
                break;
            }
        }
        
        return $altura_valor;
    }

    public static function getBalanco() 
    {
        $balanco = [
            ['balanco' => '4,88m'],
            ['balanco' => '11,73m'],
            ['balanco' => '16,31m'],
            ['balanco' => '20,88m'],
            ['balanco' => '25,45m']
        ];
        return $balanco;
    }

    public static function getPainel() 
    {
        $painel = [
            ['painel' => 'ICON10'],
            ['painel' => 'ICON5'],
            ['painel' => 'ICONX'],
            ['painel' => 'ICON1'],
            ['painel' => 'STANDARD/CLASSIC PLUS'],
            ['painel' => 'PRO2'],
            ['painel' => 'AUTOPILOT']
        ];
        return $painel;
    }

    public static function getRaioUltimaTorre()
    {
        $raio_ultima_torre = [['x'], ['y'], ['z']];

        return $raio_ultima_torre;
    }

    public static function getArea()
    {
        $area = [['x'], ['y'], ['z']];

        return $area;
    }

    public static function getLamina()
    {
        $lamina_100 = [['x'], ['y'], ['z']];

        return $lamina_100;
    }

}
