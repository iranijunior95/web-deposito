<?php

namespace App\Controllers;

class Conferentes extends BaseController {

    public function index() {
        $dados = [
            'titulo' => 'CONFERENTES',
            'menu' => 'cadastros',
            'tela' => 'conferentes/view_index_conferentes',
            'js' => [
                '/assets/sistema/js/conferentes/script_index_conferentes.js'
            ]
        ];

        return view('view_index', $dados);
    }

}
