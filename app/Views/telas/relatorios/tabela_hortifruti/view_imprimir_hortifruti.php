<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>IMPRIMIR TABELA HORTIFRUTI</title>

        <!-- Bootstrap -->
        <link href="<?=base_url()?>/assets/template/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
        .campoId {
          width: 40px;
          font-size: 16px;
          height: 30px;
        }

        .campoDescricao {
          width: 225px;
          font-size: 16px;
          height: 30px;
        }

        .campoUncCx {
          width: 100px;
          font-size: 16px;
          height: 30px;
        }

        .campoKg {
            width: 125px;
          font-size: 16px;
          height: 30px;
        }

        .campoObservacoes {
            width: 350px;
          font-size: 16px;
          height: 30px;
        }
        </style>
    </head>
    <body>
            
        <div class="container">
            <div class="row text-center">
                <img src="<?=base_url()?>/assets/sistema/img/logo_oficial.png" width="207" height="80" class="user-image" alt="logo">

                <h4>CONFERÊNCIA CEGA - HORTIFRUTI</h4>
            </div>

            <br>

            <div class="row">
                <table class="table">
					<tbody>
						<tr>
                            <th class="text-left" style="width: 250px;"><p>DATA: <?=date('d/m/Y',  strtotime($dadosHorti[0]['data_horti']))?></p></th>
							<th class="text-center" style="width: 250px;"><p>CONFERENTE: <?=strtoupper($dadosHorti[0]['nome_conferente'])?></p></th>
							<th class="text-right" style="width: 250px;"><p>MOTORISTA: <?=$dadosHorti[0]['nome_motorista_horti']?></p></th>
						</tr>
					</tbody>
				</table>
            </div>

            <div class="row">
                <table class="table table-bordered">
                    <thead style="background-color: #182226; color: #FFF">
                        <tr>
                            <th class="text-center campoId" style="background-color: #f3f0f0">#</th>
                            <th class="text-center campoDescricao" style="background-color: #f3f0f0">DESCRIÇÃO</th>
                            <th class="text-center campoUncCx" style="background-color: #f3f0f0">UND/CX</th>
                            <th class="text-center campoKg" style="background-color: #f3f0f0">KG</th>
                            <th class="text-center campoObservacoes" style="background-color: #f3f0f0">OBSERVAÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $count = 1;

                        foreach($dadosHorti as $horti) {

                            $kg;

                            if($horti['und_kg'] === 'cx') {
                                $kg = 'KG';
                            }else {
                                $kg = 'UND';
                            }
                        ?>
                            <tr>
                                <td class="text-center campoId"><?=$count++?></td>
                                <td class="text-center campoDescricao"><?=$horti['nome_produto']?></td>
                                <td class="text-center campoUncCx"><?=$horti['quantidade_cx'].' cx'?></td>
                                <td class="text-center campoKg"><?=$horti['quantidade'].' '.$kg?></td>
                                <td class="text-center campoObservacoes"></td>
                            </tr>

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>

    

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?=base_url()?>/assets/template/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
</html>