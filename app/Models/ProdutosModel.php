<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutosModel extends Model {

    protected $table                = 'produto';
    protected $primaryKey           = 'id_produto';
    protected $allowedFields        = ['cod_produto', 'nome_produto', 'status_produto'];
    protected $returnType           = 'array';

    protected $validationRules      = ['cod_produto' => 'required', 'nome_produto' => 'required'];

    protected $validationMessages   = [
        'nome_produto' => [
            'required' => 'Digite o nome do produto...'
        ],

        'cod_produto' => [
            'required' => 'Digite o código do produto...'
        ]
    ];


    public function getAllProdutos() {
        $produtos = esc($this->where('status_produto', 'on')
                                ->orderBy('nome_produto', 'ASC')
                                ->findAll());

        return $produtos;
    }

    public function saveProduto($dados) {

        if($dados['id'] > 0) {
            $produto = [
                'id_produto' => $dados['id'],
                'cod_produto' => $dados['codigo'],
                'nome_produto' => strtoupper($dados['nome'])
            ];

            if($this->save($produto)) {
                $retorno = [
                    'status' => true,
                    'mensagem' => 'Alterado com Sucesso!'
                ];
    
                return $retorno;
            }else {
                $retorno = [
                    'status' => false,
                    'mensagem' => $this->errors()
                ];
    
                return $retorno;
            }

        }else {
            $produto = [
                'cod_produto' => $dados['codigo'],
                'nome_produto' => strtoupper($dados['nome']),
                'status_produto' => 'on'
            ];
    
            if($this->save($produto)) {
                $retorno = [
                    'status' => true,
                    'mensagem' => 'Cadastrado com Sucesso!'
                ];
    
                return $retorno;
            }else {
                $retorno = [
                    'status' => false,
                    'mensagem' => $this->errors()
                ];
    
                return $retorno;
            }
        }
    }

    public function deleteProduto($dados) {
        $produto = [
            'id_produto' => $dados['id'],
            'status_produto' => 'off'
        ];

        if($this->save($produto)) {
            $retorno = [
                'status' => true,
                'mensagem' => 'Deletado com Sucesso!'
            ];

            return $retorno;
        }else {
            $retorno = [
                'status' => false,
                'mensagem' => 'Erro ao Deletar Produto!'
            ];

            return $retorno;
        }
    }

}

?>