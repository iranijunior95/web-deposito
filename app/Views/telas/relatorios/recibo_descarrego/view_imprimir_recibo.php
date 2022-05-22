<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>IMPRIMIR RECIBO</title>

        <!-- Bootstrap -->
        <link href="<?=base_url()?>/assets/template/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

    <?php
    $filial = 'ATACADÃO VICUNHA LTDA';
    $cnpjFilial = '35.298.801/0001-60';

    switch ($dadosRecibo[0]['filial']) {
        case '1':

            $filial = 'ATACADÃO VICUNHA LTDA';
            $cnpjFilial = '35.298.801/0001-60';
            break;

        case '2':
            
            $filial = 'ATACADÃO VICUNHA LTDA FILIAL';
            $cnpjFilial = '35.298.801/0003-21';
            break;

        case '3':
            
            $filial = 'COMERCIAL VICUNHA INDUSTRIA E COMERCIO LTDA';
            $cnpjFilial = '35.367.588/0001-09 ';
            break;
    
        default:
            break;
    }
    ?>
        
       <div class="container">

            <div class="row text-center">
                <img src="<?=base_url('/assets/sistema/img/logo_oficial_grupo_vicunha.png')?>" width="207" height="80">
            </div>

            <h4 class="text-center" style="font-weight: bold;">RECIBO</h4>

            <br>

            <div class="row">
                <div class="col-md-12 text-justify">
                    <p>Por meio deste documento declaro que recebi a quantia de <b style="font-weight: bold;">R$<?=$dadosRecibo[0]['valor']?></b> (<b style="font-weight: bold;"><?=$dadosRecibo[0]['valor_extenso']?></b>)
                    referente ao descarrego dos produtos constantes na(s) nota(s) fiscal(ais) de número: <b style="font-weight: bold;">“<?=$dadosRecibo[0]['numero_nota']?>”</b>, emitida(s) pelo fornecedor: <b style="font-weight: bold;"><?=$dadosRecibo[0]['nome_fornecedor']?></b>, cadastrado no CNPJ/CPF de
                    número: <b style="font-weight: bold;"><?=$dadosRecibo[0]['cnpj_cpf']?></b>.</p>
                </div>
            </div>

            <br>
			<br>
			<br>
			<br>
			<br>

            <div class="row text-center">
                <p>______________________________________________</p>
		        <p style="font-size: 11px; padding-top: -10px; font-weight: bold;"><?=$filial?></p>
		        <p style="font-size: 11px; padding-top: -13px; font-weight: bold;"><?=$cnpjFilial?></p>

                <p>CURRAIS NOVOS - RN / ( <?=implode("/",array_reverse(explode("-",$dadosRecibo[0]['data'])))?> )</p>
            </div>


            <hr>


            <div class="row text-center">
                <img src="<?=base_url().'/assets/sistema/img/logo_oficial_grupo_vicunha.png'?>" width="207" height="80">
            </div>

            <h4 class="text-center" style="font-weight: bold;">RECIBO</h4>

            <br>

            <div class="row">
                <div class="col-md-12 text-justify">
                    <p>Por meio deste documento declaro que recebi a quantia de <b style="font-weight: bold;">R$<?=$dadosRecibo[0]['valor']?></b> (<b style="font-weight: bold;"><?=$dadosRecibo[0]['valor_extenso']?></b>)
                    referente ao descarrego dos produtos constantes na(s) nota(s) fiscal(ais) de número: <b style="font-weight: bold;">“<?=$dadosRecibo[0]['numero_nota']?>”</b>, emitida(s) pelo fornecedor: <b style="font-weight: bold;"><?=$dadosRecibo[0]['nome_fornecedor']?></b>, cadastrado no CNPJ/CPF de
                    número: <b style="font-weight: bold;"><?=$dadosRecibo[0]['cnpj_cpf']?></b>.</p>
                </div>
            </div>

            <br>
			<br>
			<br>
			<br>
			<br>

            <div class="row text-center">
                <p>______________________________________________</p>
		        <p style="font-size: 11px; padding-top: -10px; font-weight: bold;"><?=$filial?></p>
		        <p style="font-size: 11px; padding-top: -13px; font-weight: bold;"><?=$cnpjFilial?></p>

                <p>CURRAIS NOVOS - RN / ( <?=implode("/",array_reverse(explode("-",$dadosRecibo[0]['data'])))?> )</p>
            </div>
       </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?=base_url()?>/assets/template/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
</html>