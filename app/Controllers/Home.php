<?php

namespace App\Controllers;

use App\Models\RelatoriosModel;
use \Mpdf\Mpdf;

class Home extends BaseController {

    public function index() {
        $dados = [
            'titulo' => 'HOME',
            'menu' => 'home',
            'tela' => 'view_home'
        ];

        return view('view_index', $dados);
    }

}
