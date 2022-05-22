<?php

namespace App\Models;

use CodeIgniter\Model;

class LancamentosModel extends Model { 

    protected $table                = 'lancamento';
    protected $primaryKey           = 'id_lancamento';
    protected $allowedFields        = [
        'numero_nota',
        'valor_nota',
        'peso_nota',
        'nome_motorista',
        'placa_veiculo',
        'taxa_descarrego',
        'hora_entrada',
        'hora_saida',
        'data_entrada',
        'data_lancamento',
        'status_lancamento',
        'fornecedor_id_fornecedor', 
        'conferente_id_conferente',
        'setor_id_setor',
    ];

    protected $returnType           = 'array';

    protected $validationRules      = [
        'numero_nota' => 'required|numeric',
        'valor_nota' => 'required',
        'nome_motorista' => 'required',
        'hora_entrada' => 'required',
        'hora_saida' => 'required',
        'data_entrada' => 'required'
    ];

    protected $validationMessages   = [
        'numero_nota' => [
            'required' => 'Digite o número da nota...',
            'numeric' => 'Esse campo só permite NÚMEROS...'
        ],

        'valor_nota' => [
            'required' => 'Digite o valor da nota...'
        ],
        
        'nome_motorista' => [
            'required' => 'Digite o nome do motorista...'
        ],

        'hora_entrada' => [
            'required' => 'Digite a hora de entrada...'
        ],
        
        'hora_saida' => [
            'required' => 'Digite a hora de saída...'
        ],

        'data_entrada' => [
            'required' => 'Digite a data de entrada...'
        ]
    ];

    public function getAllLancamentos() {
        return esc($this->from('fornecedor, setor, conferente')
                    ->where('id_fornecedor = fornecedor_id_fornecedor')
                    ->where('id_setor = setor_id_setor')
                    ->where('id_conferente = conferente_id_conferente')
                    ->where('data_entrada',retornaDataAtual())
                    ->where('status_lancamento', 'on')
                    ->orderBy('data_lancamento', 'DESC')
                    ->findAll());
    }

    public function getByIdLancamento($id) {
        return esc($this->from('fornecedor, setor, conferente')
                    ->where('id_fornecedor = fornecedor_id_fornecedor')
                    ->where('id_setor = setor_id_setor')
                    ->where('id_conferente = conferente_id_conferente')
                    ->where('status_lancamento', 'on')
                    ->find($id));

    }

    public function pesquisarLancamentos($dados) {
        $consulta = '';

        if($dados['inputFornecedor'] != 0) {
            $consulta .= ' AND fornecedor_id_fornecedor = '.$dados['inputFornecedor'];
        }

        if($dados['inputNumeroDaNota'] != '') {
            $consulta .= ' AND numero_nota = '.$dados['inputNumeroDaNota'];
        }

        if($dados['inputConferente'] != 0) {
            $consulta .= ' AND conferente_id_conferente = '.$dados['inputConferente'];
        }

        if($dados['inputSetor'] != 0) {
            $consulta .= ' AND setor_id_setor = '.$dados['inputSetor'];
        }

        if($dados['inputData'] != '') {
            $consulta .= ' AND data_entrada = "'.$dados['inputData'].'"';
        }

        $query = substr($consulta, 4);

        if($query != ''){
            return esc($this->from('fornecedor, setor, conferente')
                    ->where('id_fornecedor = fornecedor_id_fornecedor')
                    ->where('id_setor = setor_id_setor')
                    ->where('id_conferente = conferente_id_conferente')
                    ->where($query)
                    ->where('status_lancamento', 'on')
                    ->orderBy('data_lancamento', 'DESC')
                    ->findAll());
           
        }else{
            return $this->getAllLancamentos();
            
        }
    }

    public function saveLancamento($dados) {
        if($dados['id'] > 0) {

            $lancamento = [
                'numero_nota' => $dados['numeroNota'],
                'valor_nota' => $dados['valorNota'],
                'peso_nota' => validaCampoPeso($dados['pesoNota']),
                'nome_motorista' => mb_convert_case($dados['nomeMotorista'], MB_CASE_TITLE, "UTF-8"),
                'placa_veiculo' => strtoupper($dados['placaVeiculo']),
                'taxa_descarrego' => validaCampoDescarrego($dados['taxaDescarrego']),
                'hora_entrada' => $dados['horaEntrada'],
                'hora_saida' => $dados['horaSaida'],
                'data_entrada' => $dados['dataEntrada'],
                'fornecedor_id_fornecedor' => $dados['fornecedor'], 
                'conferente_id_conferente' => $dados['conferente'],
                'setor_id_setor' => $dados['setor'],
                'id_lancamento' => $dados['id']

            ];

            if($this->save($lancamento)) {
                $retorno = [
                    'status' => true,
                    'id_lancamento' => $dados['id'],
                    'mensagem' => 'Alterado com Sucesso!'
                ];
                
                session_start();
                $_SESSION['retorno'] = 'Alterado com Sucesso!';

                return $retorno;
            }else {
                $retorno = [
                    'status' => false,
                    'mensagem' => $this->errors()
                ];
    
                return $retorno;
            }
            
        }else {

            $lancamento = [
                'numero_nota' => $dados['numeroNota'],
                'valor_nota' => $dados['valorNota'],
                'peso_nota' => validaCampoPeso($dados['pesoNota']),
                'nome_motorista' => mb_convert_case($dados['nomeMotorista'], MB_CASE_TITLE, "UTF-8"),
                'placa_veiculo' => strtoupper($dados['placaVeiculo']),
                'taxa_descarrego' => validaCampoDescarrego($dados['taxaDescarrego']),
                'hora_entrada' => $dados['horaEntrada'],
                'hora_saida' => $dados['horaSaida'],
                'data_entrada' => $dados['dataEntrada'],
                'data_lancamento' => date('Y-m-d H:i:s'),
                'status_lancamento' => 'on',
                'fornecedor_id_fornecedor' => $dados['fornecedor'], 
                'conferente_id_conferente' => $dados['conferente'],
                'setor_id_setor' => $dados['setor'],

            ];

            if($this->save($lancamento)) {
                $retorno = [
                    'status' => true,
                    'id_lancamento' => $this->getInsertID(),
                    'mensagem' => 'Cadastrado com Sucesso!'
                ];
                
                session_start();
                $_SESSION['retorno'] = 'Cadastrado com Sucesso!';

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

    public function deleteLancamento($id) {
        $lancamento = [
            'id_lancamento' => $id,
            'status_lancamento' => 'off'
        ];

        if($this->save($lancamento)) {
            $retorno = [
                'status' => true,
                'mensagem' => 'Deletado com Sucesso!'
            ];

            session_start();
            $_SESSION['retorno'] = 'Deletado com Sucesso!';

            return true;
        }else {
            $retorno = [
                'status' => false,
                'mensagem' => 'Erro ao Deletar Lancamento!'
            ];

            session_start();
            $_SESSION['retorno'] = 'Erro ao Deletar Lancamento!';

            return false;
        }
    }
}