<?php

namespace App\Models;

use CodeIgniter\Model;

class ConferentesModel extends Model {

    protected $table                = 'conferente';
    protected $primaryKey           = 'id_conferente';
    protected $allowedFields        = ['nome_conferente', 'status_conferente'];
    protected $returnType           = 'array';

    protected $validationRules      = ['nome_conferente' => 'required'];

    protected $validationMessages   = [
        'nome_conferente' => [
            'required' => 'Digite o nome do conferente...'
        ]
    ];

    public function getAllConferentes() {
        $conferentes = esc($this->where('status_conferente', 'on')
                                ->orderBy('nome_conferente', 'ASC')
                                ->findAll());

        return $conferentes;
    }
        
    public function saveConferente($dados) {

        if($dados['id'] > 0) {
            $conferente = [
                'id_conferente' => $dados['id'],
                'nome_conferente' => mb_convert_case($dados['nome'], MB_CASE_TITLE, "UTF-8")
            ];

            if($this->save($conferente)) {
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
            $conferente = [
                'nome_conferente' => mb_convert_case($dados['nome'], MB_CASE_TITLE, "UTF-8"),
                'status_conferente' => 'on'
            ];
    
            if($this->save($conferente)) {
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

    public function deleteConferente($dados) {
        $conferente = [
            'id_conferente' => $dados['id'],
            'status_conferente' => 'off'
        ];

        if($this->save($conferente)) {
            $retorno = [
                'status' => true,
                'mensagem' => 'Deletado com Sucesso!'
            ];

            return $retorno;
        }else {
            $retorno = [
                'status' => false,
                'mensagem' => 'Erro ao Deletar Conferente!'
            ];

            return $retorno;
        }
    }
}
?>