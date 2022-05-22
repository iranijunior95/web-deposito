<?php

namespace App\Models;

use CodeIgniter\Model;

class RelatoriosModel extends Model { 

    protected $table                = 'relatorio';
    protected $primaryKey           = 'id_relatorio';
    protected $allowedFields        = [
        'titulo_relatorio',
        'data_relatorio',
        'data_entrada_relatorio',
        'status_relatorio'
    ];

    protected $returnType           = 'array';

    public function getByIdRelatorio($id) {
        return esc($this->from('lancamento, relatorio_has_lancamento, fornecedor, conferente')
                        ->where('id_relatorio', $id)
                        ->where('id_relatorio = relatorio_id_relatorio')
                        ->where('id_lancamento = lancamento_id_lancamento')
                        ->where('fornecedor_id_fornecedor = id_fornecedor')
                        ->where('conferente_id_conferente = id_conferente')
                        ->where('status_relatorio', 'on')
                        ->orderBy('ordem_sequencia', 'ESC')
                        ->find());
    }

    public function saveRelatorio($dados) {

        $lista = [];
        $count = 0;

        $relatorio = [
            'titulo_relatorio' => strtoupper($dados['titulo']),
            'data_relatorio' => $dados['data'],
            'data_entrada_relatorio' => date('Y-m-d H:i:s'),
            'status_relatorio' => 'on'
        ];

        if($this->save($relatorio)) {

            foreach($dados['lista'] as $l) {
                array_push($lista,array (
                    'relatorio_id_relatorio' => $this->getInsertID(),
                    'lancamento_id_lancamento' => $l['id_lancamento'],
                    'ordem_sequencia' => $count++
                ));
            }
            
            $db = \Config\Database::connect();
            $builder = $db->table('relatorio_has_lancamento');

            if($builder->insertBatch($lista)){
                $retorno = [
                    'status' => true,
                    'id_relatorio' => $this->getInsertID()
                ];

                return $retorno;
            }else {
                $retorno = [
                    'status' => false,
                    'mensagem' => 'Erro! Problema ao gerar relatório!'
                ];
    
                return $retorno;
            }
            
        }else {
            $retorno = [
                'status' => false,
                'mensagem' => 'Erro! Problema ao gerar relatório!'
            ];

            return $retorno;
        }
    }

}