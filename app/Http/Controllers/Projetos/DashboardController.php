<?php

namespace App\Http\Controllers\Projetos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\Classes\EntregaTecnica\EntregaTecnica;
use App\Classes\Sistema\Fazenda;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index(){
        $user = Auth::user()->nome;    
      
        return view('sistema.dashboard', compact('user'));
    }
}
