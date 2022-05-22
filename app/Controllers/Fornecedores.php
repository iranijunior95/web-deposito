<?php

namespace App\Controllers;

class Fornecedores extends BaseController {

    public function index() {
        $dados = [
            'titulo' => 'FORNECEDORES',
            'menu' => 'cadastros',
            'tela' => 'fornecedores/view_index_fornecedores',
            'js' => [
                '/assets/sistema/js/fornecedores/script_index_fornecedores.js'
            ]
        ];

        return view('view_index', $dados);
    }
}