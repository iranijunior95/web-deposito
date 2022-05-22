<?php

namespace App\Controllers;

use App\Models\ConferentesModel;
use App\Models\FornecedoresModel;
use App\Models\HortifrutiModel;
use App\Models\SetoresModel;
use App\Models\LancamentosModel;
use App\Models\ProdutosModel;
use App\Models\RecibosModel;
use App\Models\RelatoriosModel;
use \Mpdf\Mpdf;

class Relatorios extends BaseController {

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

    public function index() {
        $dados = [
            'titulo' => 'RELATÓRIOS',
            'menu' => 'relatorios',
            'tela' => 'relatorios/view_index_relatorios'
        ];

        return view('view_index', $dados);
    }

    //Relatório de Lançamentos
    public function relatorio_lancamentos() {
        $dados = [
            'titulo' => 'RELATÓRIOS',
            'menu' => 'relatorios',
            'tela' => 'relatorios/relatorio_lancamento/view_index_relatorio_lancamentos',
            'fornecedores' => $this->fornecedoresModel->getAllFornecedores(),
            'conferentes' => $this->conferentesModel->getAllConferentes(),
            'setores' => $this->setoresModel->getAllSetores(),
            'js' => [
                '/assets/sistema/js/relatorios/script_index_relatorio_lancamentos.js'
            ]
        ];

        return view('view_index', $dados);
    }

    public function imprimir_relatorio_lancamentos($id) {
        $dados['dadosRelatorio'] = $this->relatoriosModel->getByIdRelatorio($id);
                
        $mpdf = new Mpdf(['orientation' => 'L']);
        $html = view('telas/relatorios/relatorio_lancamento/view_imprimir_relatorio', $dados,[]);
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output($dados['dadosRelatorio'][0]['titulo_relatorio'].'-'.$dados['dadosRelatorio'][0]['data_relatorio'].'.pdf','I');
        
    }

    //Recibo de Descarrego
    public function recibo_descarrego() {
        $dados = [
            'titulo' => 'RELATÓRIOS',
            'menu' => 'relatorios',
            'tela' => 'relatorios/recibo_descarrego/view_index_recibo_descarrego',
            'fornecedores' => $this->fornecedoresModel->getAllFornecedores(),
            'js' => [
                '/assets/sistema/js/relatorios/script_index_recibo_descarrego.js'
            ]
        ];

        return view('view_index', $dados);
    }

    public function imprimir_recibo_descarrego($id) {
        $dados['dadosRecibo'] = $this->recibosModel->getByIdRecibo($id);
        
        
        $mpdf = new Mpdf(['orientation' => '']);
        $html = view('telas/relatorios/recibo_descarrego/view_imprimir_recibo', $dados,[]);
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output($dados['dadosRecibo'][0]['nome_fornecedor'].'-'.$dados['dadosRecibo'][0]['data'].'.pdf','I');

        
    }

    //Tabela de Hortifruti
    public function tabela_hortifruti() {
        $dados = [
            'titulo' => 'RELATÓRIOS',
            'menu' => 'relatorios',
            'tela' => 'relatorios/tabela_hortifruti/view_index_tabela_hortifruti',
            'produtos' => $this->produtosModel->getAllProdutos(),
            'conferentes' => $this->conferentesModel->getAllConferentes(),
            'js' => [
                '/assets/sistema/js/relatorios/script_index_tabela_hortifruti.js'
            ]
        ];

        return view('view_index', $dados);
    }

    public function imprimir_tabela_hortifruti($id) {
        $dados['dadosHorti'] = $this->hortifrutiModel->getByIdHortifruti($id);

        $mpdf = new Mpdf(['orientation' => '']);
        $html = view('telas/relatorios/tabela_hortifruti/view_imprimir_hortifruti', $dados,[]);
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output($dados['dadosHorti'][0]['titulo_tabela_horti'].'.pdf','I');
    }

}