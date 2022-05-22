<?php

namespace App\Controllers;

use App\Models\ConferentesModel;
use App\Models\FornecedoresModel;
use App\Models\SetoresModel;
use App\Models\LancamentosModel;

class Lancamentos extends BaseController {

    protected $conferentesModel;
    protected $fornecedoresModel;
    protected $setoresModel;
    protected $lancamentosModel;

	public function __construct() {
		
		$this->conferentesModel = new ConferentesModel();
        $this->fornecedoresModel = new FornecedoresModel();
        $this->setoresModel = new SetoresModel();
        $this->lancamentosModel = new LancamentosModel();
	}

    public function index() {
        $dados = [
            'titulo' => 'LANÇAMENTOS',
            'menu' => 'lancamentos',
            'tela' => 'lancamentos/view_index_lancamentos',
            'fornecedores' => $this->fornecedoresModel->getAllFornecedores(),
            'conferentes' => $this->conferentesModel->getAllConferentes(),
            'setores' => $this->setoresModel->getAllSetores(),
            'js' => [
                '/assets/sistema/js/lancamentos/script_index_lancamentos.js'
            ]
        ];

        return view('view_index', $dados);
    }

    public function form_save() {
        $dados = [
            'titulo' => 'LANÇAMENTOS',
            'menu' => 'lancamentos',
            'tela' => 'lancamentos/view_form_save_lancamentos',
            'fornecedores' => $this->fornecedoresModel->getAllFornecedores(),
            'conferentes' => $this->conferentesModel->getAllConferentes(),
            'setores' => $this->setoresModel->getAllSetores(),
            'js' => [
                '/assets/sistema/js/lancamentos/script_form_lancamentos.js'
            ]
        ];

        return view('view_index', $dados);
    }

    public function form_edit($id) {
        $dados = [
            'titulo' => 'LANÇAMENTOS',
            'menu' => 'lancamentos',
            'tela' => 'lancamentos/view_form_edit_lancamentos',
            'fornecedores' => $this->fornecedoresModel->getAllFornecedores(),
            'conferentes' => $this->conferentesModel->getAllConferentes(),
            'setores' => $this->setoresModel->getAllSetores(),
            'lancamento' => $this->lancamentosModel->getByIdLancamento($id),
            'js' => [
                '/assets/sistema/js/lancamentos/script_form_lancamentos.js'
            ]
        ];

        return view('view_index', $dados);
    }

    public function detalhes($id) {
        $dados = [
            'titulo' => 'LANÇAMENTOS',
            'menu' => 'lancamentos',
            'tela' => 'lancamentos/view_detalhes_lancamentos',
            'lancamento' => $this->lancamentosModel->getByIdLancamento($id),
            'js' => [
                '/assets/sistema/js/lancamentos/script_detalhes_lancamentos.js'
            ]
        ];

        return view('view_index', $dados);
    }

    public function delete($id) {
        if($this->lancamentosModel->deleteLancamento($id)) {
            redirect(base_url('lancamentos'));
        }else {
            redirect(base_url('lancamentos/detalhes/'.$id));
        }
    }

}
