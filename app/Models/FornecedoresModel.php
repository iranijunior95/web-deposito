<?php

namespace App\Models;

use CodeIgniter\Model;

class FornecedoresModel extends Model {

    protected $table                = 'fornecedor';
    protected $primaryKey           = 'id_fornecedor';
    protected $allowedFields        = ['nome_fornecedor', 'cnpj_cpf', 'status_fornecedor'];
    protected $returnType           = 'array';

    protected $validationRules      = ['nome_fornecedor' => 'required', 'cnpj_cpf' => 'required|not_in_list[naovalido, no]|max_length[18]'];

    protected $validationMessages   = [
        'nome_fornecedor' => [
            'required' => 'Digite o nome do fornecedor...'
        ],

        'cnpj_cpf' => [
            'required' => 'Digite o CNPJ ou CPF do fornecedor...',
            'not_in_list' => 'O formato do campo não é válido...',
            'max_length' => 'O campo deve conter no máximo 18 dígitos...'
        ]
    ];

    public function getAllFornecedores() {
        $fornecedores = esc($this->where('status_fornecedor', 'on')
                                ->orderBy('nome_fornecedor', 'ASC')
                                ->findAll());

        return $fornecedores;
    }

    public function getByIdFornecedores($id) {
        return esc($this->where('status_fornecedor', 'on')
                        ->find($id));
    }

    public function saveFornecedor($dados) {
        if($dados['id'] > 0) {
            $fornecedor = [
                'id_fornecedor' => $dados['id'],
                'nome_fornecedor' => strtoupper($dados['nome']),
                'cnpj_cpf' => validaCpfCnpj($dados['cnpj_cpf'])
            ];

            if($this->save($fornecedor)) {
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
            $fornecedor = [
                'nome_fornecedor' => strtoupper($dados['nome']),
                'cnpj_cpf' => validaCpfCnpj($dados['cnpj_cpf']),
                'status_fornecedor' => 'on'
            ];
    
            if($this->save($fornecedor)) {
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

    public function deleteFornecedor($dados) {
        $fornecedor = [
            'id_fornecedor' => $dados['id'],
            'status_fornecedor' => 'off'
        ];

        if($this->save($fornecedor)) {
            $retorno = [
                'status' => true,
                'mensagem' => 'Deletado com Sucesso!'
            ];

            return $retorno;
        }else {
            $retorno = [
                'status' => false,
                'mensagem' => 'Erro ao Deletar Fornecedor!'
            ];

            return $retorno;
        }
    }

}

?>