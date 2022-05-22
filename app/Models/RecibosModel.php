<?php

namespace App\Models;

use CodeIgniter\Model;

class RecibosModel extends Model { 

    protected $table                = 'recibo';
    protected $primaryKey           = 'id_recibo';
    protected $allowedFields        = [
        'filial',
        'logo_filial',
        'numero_nota',
        'valor',
        'valor_extenso',
        'data',
        'status_recibo',
        'fornecedor_id_fornecedor'
    ];

    protected $returnType           = 'array';

    protected $fornecedorModel;


    public function getByIdRecibo($id) {
        return esc($this->from('fornecedor')
                        ->where('id_recibo', $id)
                        ->where('fornecedor_id_fornecedor = id_fornecedor')
                        ->where('status_recibo', 'on')
                        ->find());
    }

    public function saveRecibo($dados) {
        $dadosRecibo = [
            'filial' => $dados['filial'],
            'logo_filial' => 'logo_oficial_filial_'.$dados['filial'].'.png',
            'numero_nota' => $dados['numero_nota'],
            'valor' => $dados['valor'],
            'valor_extenso' => $this->converteValorPorExtenso($dados['valor'], 2),
            'data' => $dados['data'],
            'status_recibo' => 'on',
            'fornecedor_id_fornecedor' => $dados['fornecedor']
        ];

        if($this->save($dadosRecibo)) {
            $retorno = [
                'status' => true,
                'id_recibo' => $this->getInsertID()
            ];

            return $retorno;

        }else {
            $retorno = [
                'status' => false,
                'mensagem' => 'Erro! Problema ao gerar recibo!'
            ];

            return $retorno;
        }
    }

    public function retornaDadosRecibos($dados) {

        $this->fornecedorModel = new FornecedoresModel();

        $dadosRecibo = [
            'filial' => $dados['filial'],
            'logo_filial' => base_url().'/assets/sistema/img/logo_oficial_filial_'.$dados['filial'].'.png',
            'fornecedor' => $this->fornecedorModel->getByIdFornecedores($dados['fornecedor']),
            'numero_nota' => $dados['numero_nota'],
            'valor' => $dados['valor'],
            'valor_extenso' => $this->converteValorPorExtenso($dados['valor'], 2),
            'data' => implode("/",array_reverse(explode("-",$dados['data'])))
        ];

        return $dadosRecibo;
    }

    private function converteValorPorExtenso($value, $uppercase = 0) {
        if (strpos($value, ",") > 0) {
            $value = str_replace(".", "", $value);
            $value = str_replace(",", ".", $value);
        }
        $singular = ["centavo", "real", "mil", "milhÃo", "bilhÃo", "trilhÃo", "quatrilhÃo"];
        $plural = ["centavos", "reais", "mil", "milhÕes", "bilhÕes", "trilhÕes", "quatrilhÕes"];
     
        $c = ["", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"];
        $d = ["", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa"];
        $d10 = ["dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove"];
        $u = ["", "um", "dois", "trÊs", "quatro", "cinco", "seis", "sete", "oito", "nove"];
     
        $z = 0;
     
        $value = number_format($value, 2, ".", ".");
        $integer = explode(".", $value);
        $cont = count($integer);
        for ($i = 0; $i < $cont; $i++)
            for ($ii = strlen($integer[$i]); $ii < 3; $ii++)
                $integer[$i] = "0" . $integer[$i];
     
        $fim = $cont - ($integer[$cont - 1] > 0 ? 1 : 2);
        $rt = '';
        for ($i = 0; $i < $cont; $i++) {
            $value = $integer[$i];
            $rc = (($value > 100) && ($value < 200)) ? "cento" : $c[$value[0]];
            $rd = ($value[1] < 2) ? "" : $d[$value[1]];
            $ru = ($value > 0) ? (($value[1] == 1) ? $d10[$value[2]] : $u[$value[2]]) : "";
     
            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd &&
                    $ru) ? " e " : "") . $ru;
            $t = $cont - 1 - $i;
            $r .= $r ? " " . ($value > 1 ? $plural[$t] : $singular[$t]) : "";
            if ($value == "000"
            )
                $z++;
            elseif ($z > 0)
                $z--;
            if (($t == 1) && ($z > 0) && ($integer[0] > 0))
                $r .= ( ($z > 1) ? " de " : "") . $plural[$t];
            if ($r)
                $rt = $rt . ((($i > 0) && ($i <= $fim) &&
                        ($integer[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }
     
        if (!$uppercase) {
            return trim($rt ? $rt : "zero");
        } elseif ($uppercase == "2") {
            return trim(strtoupper($rt) ? strtoupper(strtoupper($rt)) : "Zero");
        } else {
            return trim(ucwords($rt) ? ucwords($rt) : "Zero");
        }
    }
}