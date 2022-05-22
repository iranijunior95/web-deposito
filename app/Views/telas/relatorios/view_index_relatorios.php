<div class="container">
    <br>

    <div class="row">
        <div class="col-md-12">
			<div class="box box-solid">
				<div class="box-body text-center" style="background-color: #008d4c; color:#FFFFFF">
					<h2><i class="fa fa-bar-chart"></i> RELATÓRIOS</h2>
				</div>

				<div class="box-footer">
					<div class="row text-center">
                        <div class="col-md-3">
                            <a href="<?=base_url('relatorios/relatorio_lancamentos')?>" class="btn btn-app btn-flat">
                                <i class="fa fa-file-word-o"></i> <strong>GERAR RELATÓRIO DE LANÇAMENTOS</strong>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="<?=base_url('relatorios/recibo_descarrego')?>" class="btn btn-app btn-flat">
                                <i class="fa fa-files-o"></i> <strong>GERAR RECIBO DE DESCARREGO</strong>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="<?=base_url('relatorios/tabela_hortifruti')?>" class="btn btn-app btn-flat">
                                <i class="fa fa-file-excel-o"></i> <strong>GERAR TABELA DE HORTIFRUTI</strong>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a class="btn btn-app btn-flat">
                                <i class="fa fa-file-pdf-o"></i> <strong>GERAR TABELA DE NOTA AVULSA</strong>
                            </a>
                        </div>
                    </div>

                    <p class="page-header"></p>

                    <h4 class="text-center">IMPRIMIR MODELOS EM PDF</h4>

                    <br>

                    <table class="table">
                        <tbody>
                            <tr>
                                <td><strong>TABELA DE RECEBIMENTO DE MERCADORIA :</strong></td>
                                <td class="text-right"><a href="<?=base_url()?>/assets/sistema/arquivos/tabela_recebimento_mercadoria.pdf" target="_blank"><i class="glyphicon glyphicon-print"></i> <strong>IMPRIMIR</strong></a></td>
                            </tr>
                            <tr>
                                <td><strong>TABELA CONFERÊNCIA CEGA HORTIFRUTI :</strong></td>
                                <td class="text-right"><a href="<?=base_url()?>/assets/sistema/arquivos/hortifruti.pdf" target="_blank"><i class="glyphicon glyphicon-print"></i> <strong>IMPRIMIR</strong></a></td>
                            </tr>
                            <tr>
                                <td><strong>TABELA DE COMPRA AVULSA :</strong></td>
                                <td class="text-right"><a href="<?=base_url()?>/assets/sistema/arquivos/nota_avulsa.pdf" target="_blank"><i class="glyphicon glyphicon-print"></i> <strong>IMPRIMIR</strong></a></td>
                            
                            <tr>
                                <td><strong>TABELA DE COMPRA AVULSA (AÇOUGUE) :</strong></td>
                                <td class="text-right"><a href="<?=base_url()?>/assets/sistema/arquivos/nota_avulsa_acougue.pdf" target="_blank"><i class="glyphicon glyphicon-print"></i> <strong>IMPRIMIR</strong></a></td>
                            
                            <tr>
                                <td><strong>TABELA POSIÇÃO DE ESTOQUE :</strong></td>
                                <td class="text-right"><a href="<?=base_url()?>/assets/sistema/arquivos/planilha_posição_de_estoque.pdf" target="_blank"><i class="glyphicon glyphicon-print"></i> <strong>IMPRIMIR</strong></a></td>
                        </tbody>
                    </table>
				</div>
			</div>
		</div>
    </div>

</div>