<?php

namespace App\Controllers;

class Produtos extends BaseController {

    public function index() {
        $dados = [
            'titulo' => 'PRODUTOS',
            'menu' => 'cadastros',
            'tela' => 'produtos/view_index_produtos',
            'js' => [
                '/assets/sistema/js/produtos/script_index_produtos.js'
            ]
        ];

        return view('view_index', $dados);
    }
}