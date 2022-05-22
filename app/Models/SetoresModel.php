<?php

namespace App\Models;

use CodeIgniter\Model;

class SetoresModel extends Model {

    protected $table                = 'setor';
    protected $primaryKey           = 'id_setor';
    protected $allowedFields        = ['nome_setor', 'status_setor'];
    protected $returnType           = 'array';

    protected $validationRules      = ['nome_setor' => 'required'];

    protected $validationMessages   = [
        'nome_setor' => [
            'required' => 'Digite o nome do setor...'
        ]
    ];

    public function getAllSetores() {
        $setores = esc($this->where('status_setor', 'on')
                                ->orderBy('nome_setor', 'ASC')
                                ->findAll());

        return $setores;
    }

    public function saveSetor($dados) {

        if($dados['id'] > 0) {
            $setor = [
                'id_setor' => $dados['id'],
                'nome_setor' => mb_convert_case($dados['nome'], MB_CASE_TITLE, "UTF-8")
            ];

            if($this->save($setor)) {
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
            $setor = [
                'nome_setor' => mb_convert_case($dados['nome'], MB_CASE_TITLE, "UTF-8"),
                'status_setor' => 'on'
            ];
    
            if($this->save($setor)) {
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

    public function deleteSetor($dados) {
        $setor = [
            'id_setor' => $dados['id'],
            'status_setor' => 'off'
        ];

        if($this->save($setor)) {
            $retorno = [
                'status' => true,
                'mensagem' => 'Deletado com Sucesso!'
            ];

            return $retorno;
        }else {
            $retorno = [
                'status' => false,
                'mensagem' => 'Erro ao Deletar Setor!'
            ];

            return $retorno;
        }
    }

}

?>