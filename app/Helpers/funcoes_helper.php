<?php 
function validaCpfCnpj($inputCnpj_cpf) {
   
    $retorno = 'naovalido';
    if(strlen($inputCnpj_cpf) == 14) {
        return formataCpfCnpj($inputCnpj_cpf);
    }
    if(strlen($inputCnpj_cpf) == 18) {
        return formataCpfCnpj($inputCnpj_cpf);
    }
    if(strlen($inputCnpj_cpf) > 18){
        return $inputCnpj_cpf;
    }
    if(strlen($inputCnpj_cpf) == 0) {
        return '';
    }

    return $retorno;
}

function formataCpfCnpj($cpf_cnpj) {
    $cpf_cnpj = preg_replace("/[^0-9]/", "", $cpf_cnpj);
    $tipo_dado = NULL;
    if(strlen($cpf_cnpj)==11){
        $tipo_dado = "cpf";
    }
    if(strlen($cpf_cnpj)==14){
        $tipo_dado = "cnpj";
    }
    switch($tipo_dado){
        default:
            $cpf_cnpj_formatado = "Não foi possível definir tipo de dado";
        break;

        case "cpf":
            $bloco_1 = substr($cpf_cnpj,0,3);
            $bloco_2 = substr($cpf_cnpj,3,3);
            $bloco_3 = substr($cpf_cnpj,6,3);
            $dig_verificador = substr($cpf_cnpj,-2);
            $cpf_cnpj_formatado = $bloco_1.".".$bloco_2.".".$bloco_3."-".$dig_verificador;
        break;

        case "cnpj":
            $bloco_1 = substr($cpf_cnpj,0,2);
            $bloco_2 = substr($cpf_cnpj,2,3);
            $bloco_3 = substr($cpf_cnpj,5,3);
            $bloco_4 = substr($cpf_cnpj,8,4);
            $digito_verificador = substr($cpf_cnpj,-2);
            $cpf_cnpj_formatado = $bloco_1.".".$bloco_2.".".$bloco_3."/".$bloco_4."-".$digito_verificador;
        break;
    }
    return $cpf_cnpj_formatado;
}

function validaCampoPeso($peso) {

    if($peso == ''):
        return '0.000';
    else:
        return $peso;
    endif;
}

function validaCampoDescarrego($valor) {
    if($valor == ''):
        return '0,00';
    else:
        return $valor;
    endif;
}

function retornaDataAtual() {
    $timezone = new DateTimeZone('America/Fortaleza');
    $agora = new DateTime('now', $timezone); 

    return $agora->format('Y-m-d');
}
?>