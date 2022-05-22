<?php

namespace App\Controllers;

class Setores extends BaseController {

    public function index() {
        $dados = [
            'titulo' => 'SETORES',
            'menu' => 'cadastros',
            'tela' => 'setores/view_index_setores',
            'js' => [
                '/assets/sistema/js/setores/script_index_setores.js'
            ]
        ];

        return view('view_index', $dados);
    }
}