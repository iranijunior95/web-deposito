<?php

namespace App\Models;

use CodeIgniter\Model;

class HortifrutiModel extends Model { 

    protected $table                = 'hortifruti';
    protected $primaryKey           = 'id_hortifruti';
    protected $allowedFields        = [
        'titulo_tabela_horti',
        'nome_motorista_horti',
        'data_horti',
        'data_entrada_horti',
        'status_horti',
        'conferente_id_conferente'
    ];

    protected $returnType           = 'array';


    public function getByIdHortifruti($id) {
        return esc($this->from('conferente, produto, produto_has_hortifruti')
                        ->where('id_hortifruti', $id)
                        ->where('id_hortifruti = hortifruti_id_hortifruti')
                        ->where('id_produto = produto_id_produto')
                        ->where('conferente_id_conferente = id_conferente')
                        ->where('status_horti', 'on')
                        ->orderBy('nome_produto', 'ESC')
                        ->find());
    }

    public function saveHortifruti($dados) {

        $lista = [];

        $hortifruti = [
            'titulo_tabela_horti' => 'tabela_horti_'.date('Y-m-d').'_'.rand(100, 999),
            'nome_motorista_horti' => strtoupper($dados['motorista']),
            'data_horti' => $dados['data'],
            'data_entrada_horti' => date('Y-m-d H:i:s'),
            'status_horti' => 'on',
            'conferente_id_conferente' => $dados['conferente']
        ];

        
        if($this->save($hortifruti)) {

            foreach($dados['tabela'] as $t) {
                array_push($lista,array (
                    'hortifruti_id_hortifruti' => $this->getInsertID(),
                    'produto_id_produto' => $t['id_produto'],
                    'und_kg' => $t['undCx'],
                    'quantidade_cx' => $t['qtd'],
                    'quantidade' => $t['kg']
                ));
            }
            
            $db = \Config\Database::connect();
            $builder = $db->table('produto_has_hortifruti');

            if($builder->insertBatch($lista)){
                $retorno = [
                    'status' => true,
                    'id_hortifruti' => $this->getInsertID()
                ];

                return $retorno;
            }else {
                $retorno = [
                    'status' => false,
                    'mensagem' => 'Erro! Problema ao gerar tabela!'
                ];
    
                return $retorno;
            }
            
        }else {
            $retorno = [
                'status' => false,
                'mensagem' => 'Erro! Problema ao gerar tabela!'
            ];

            return $retorno;
        }

        
    }
}