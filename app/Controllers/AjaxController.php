<?php

namespace App\Controllers;

use App\Models\ConferentesModel;
use App\Models\FornecedoresModel;
use App\Models\SetoresModel;
use App\Models\LancamentosModel;
use App\Models\ProdutosModel;
use App\Models\RecibosModel;
use App\Models\RelatoriosModel;
use App\Models\HortifrutiModel;

class AjaxController extends BaseController {

    protected $conferentesModel;
    protected $fornecedoresModel;
    protected $setoresModel;
    protected $produtosModel;
    protected $lancamentosModel;
    protected $relatoriosModel;
    protected $recibosModel;
    protected $hortifrutiModel;

	public function __construct() {
		
		$this->conferentesModel = new ConferentesModel();
        $this->fornecedoresModel = new FornecedoresModel();
        $this->setoresModel = new SetoresModel();
        $this->produtosModel = new ProdutosModel();
        $this->lancamentosModel = new LancamentosModel();
        $this->relatoriosModel = new RelatoriosModel();
        $this->recibosModel = new RecibosModel();
        $this->hortifrutiModel = new HortifrutiModel();
	}

    public function requisicoesAjax() {

        $tabela = $this->request->getPost('tabela');
        $metodo = $this->request->getPost('metodo');
        $dados = $this->request->getPost('dados');

        if(empty($tabela) || empty($metodo)) {
            $resposta = [
                'status' => false,
                'mensagem' => 'Erro! Problema de requisicao!'
            ];

            echo json_encode($resposta);

        }else {

            switch ($tabela) {
                case 'conferentes':
                    $this->requisicoesConferentes($metodo, $dados);
                    break;

                case 'fornecedores':
                    $this->requisicoesFornecedores($metodo, $dados);
                    break;

                case 'setores':
                    $this->requisicoesSetores($metodo, $dados);
                    break;

                case 'produtos':
                    $this->requisicoesProdutos($metodo, $dados);
                    break;

                case 'lancamentos':
                    $this->requisicoesLancamentos($metodo, $dados);
                    break;


                case 'relatorios':
                    $this->requisicoesRelatorios($metodo, $dados);
                    break;
            }

        }
    }

    private function requisicoesConferentes($metodo, $dados) {

        switch ($metodo) {
            case 'getAllConferentes':
                echo json_encode($this->conferentesModel->getAllConferentes());
                break;

            case 'save':
                echo json_encode($this->conferentesModel->saveConferente($dados));
                break;

            case 'delete':
                echo json_encode($this->conferentesModel->deleteConferente($dados));
                break;
        }
    }

    private function requisicoesFornecedores($metodo, $dados) {

        switch ($metodo) {
            case 'getAllFornecedores':
                echo json_encode($this->fornecedoresModel->getAllFornecedores());
                break;

            case 'getByIdFornecedores':
                echo json_encode($this->fornecedoresModel->getByIdFornecedores($dados));
                break;

            case 'save':
                echo json_encode($this->fornecedoresModel->saveFornecedor($dados));
                break;

            case 'delete':
                echo json_encode($this->fornecedoresModel->deletefornecedor($dados));
                break;
        }
    }

    private function requisicoesSetores($metodo, $dados) {

        switch ($metodo) {
            case 'getAllSetores':
                echo json_encode($this->setoresModel->getAllSetores());
                break;

            case 'save':
                echo json_encode($this->setoresModel->saveSetor($dados));
                break;

            case 'delete':
                echo json_encode($this->setoresModel->deleteSetor($dados));
                break;
        }
    }

    private function requisicoesProdutos($metodo, $dados) {

        switch ($metodo) {
            case 'getAllProdutos':
                echo json_encode($this->produtosModel->getAllProdutos());
                break;

            case 'save':
                echo json_encode($this->produtosModel->saveProduto($dados));
                break;

            case 'delete':
                echo json_encode($this->produtosModel->deleteProduto($dados));
                break;
        }
    }

    private function requisicoesLancamentos($metodo, $dados) {
        switch ($metodo) {
            case 'save':
                echo json_encode($this->lancamentosModel->saveLancamento($dados));
                break;
            
            case 'getAllLancamentos':
                echo json_encode($this->lancamentosModel->getAllLancamentos($dados));
                break;

            case 'pesquisarLancamentos':
                echo json_encode($this->lancamentosModel->pesquisarLancamentos($dados));
                break;

            case 'delete':
                echo json_encode($this->lancamentosModel->deleteLancamento($dados));
                break;
        }
    }

    private function requisicoesRelatorios($metodo, $dados) {
        switch ($metodo) {
            case 'imprimir':
                echo json_encode($this->relatoriosModel->saveRelatorio($dados));

                break;

            case 'retornaDados':
                echo json_encode($this->recibosModel->retornaDadosRecibos($dados));

                break;

            case 'saveRecibo':
                echo json_encode($this->recibosModel->saveRecibo($dados));

                break;

            case 'saveTabelahorti':
                echo json_encode($this->hortifrutiModel->saveHortifruti($dados));

                break;
        }
    }

}
?>