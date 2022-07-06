<?php

namespace App\Http\Controllers\Sistema;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Constantes\Notificacao;
use Illuminate\Support\Facades\DB;
use App\Classes\Sistema\Empresa;
use Session;
use Auth;
use App\Classes\Sistema\CountryLanguage;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller
{
    /**
     * check for email address
     *
     * @param $request
     * @return json
     */
    public function checkEmail(Request $request)
    {
        $email = $request->only(['email']);
        // $data = DB::table('empresa')->where('email',$email)->count();
        $data = Empresa::where('email',$email)->count();
        if ($data > 0)
        {
            return true;               
        }
        else
        {
            return false;
        }
    }
}
