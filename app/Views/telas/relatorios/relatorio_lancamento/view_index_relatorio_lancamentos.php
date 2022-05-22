<div class="container">
    <br>

    <div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-body text-center" style="background-color: #008d4c; color:#FFFFFF">
					<h2><i class="fa fa-file-word-o"></i> RELATÓRIO DE LANÇAMENTOS</h2>
				</div>
				<div class="box-footer text-center">
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modalBuscarLancamentos"><i class="fa fa-search"></i> <b>BUSCAR LANÇAMENTOS</b></button>
				</div>
			</div>
		</div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="box box-solid">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-bordered">
                        <thead style="background-color: #182226; color: #FFF">
                            <tr>
                                <th style="width: 3%;" class="text-center">#</th>
                                <th class="text-center">FORNECEDOR</th>
                                <th class="text-center">Nº NOTA FISCAL</th>
                                <th class="text-center">VALOR DA NOTA</th>
                                <th class="text-center">CONFERENTE</th>
                                <th class="text-center">DATA ENTRADA</th>
                                <th class="text-center">ENTRADA</th>
                                <th class="text-center">SAÍDA</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody id="listaDeLancamentoRelatorio">   
                            <tr>
                                <td colspan="10" class="text-center">Relatório Vazio</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer text-center" id="footer">
                    
                </div>
            </div>

        </div>
    </div>

</div>

<!-- Modal Buscar Lançamentos -->
<div class="modal fade bs-example-modal-lg" id="modalBuscarLancamentos" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog modal-lg">
    	<div class="modal-content">
        	<div class="modal-header text-center" style="background-color: #188b26; color:#FFFFFF">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>    
                <h4 class="modal-title">BUSCAR LANÇAMENTOS</h4>
            </div>

            <div class="modal-body">
	            <div class="box-body" id="divPesquisa">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="inputFornecedor">FORNECEDOR:</label>
                                <select class="form-control select2" style="width: 100%;" id="inputFornecedor" name="inputFornecedor">
                                    <option selected="true" value="0"></option>

                                    <?php
                                    foreach($fornecedores as $forn) {
                                    ?>
                                    <option value="<?=$forn['id_fornecedor']?>"><?=$forn['nome_fornecedor']?></option>
                                    <?php
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="inputNumeroDaNota">Nº DA NOTA:</label>
                                <input type="number" class="form-control" id="inputNumeroDaNota" name="inputNumeroDaNota">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="inputSetor">SETOR:</label>
                                <select class="form-control" id="inputSetor" name="inputSetor">
                                    <option selected="true" value="0"></option>

                                    <?php
                                    foreach($setores as $set) {
                                    ?>
                                    <option value="<?=$set['id_setor']?>"><?=$set['nome_setor']?></option>
                                    <?php
                                    }
                                    ?>
                                    
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>DATA DE ENTRADA:</label>
                                <input type="date" class="form-control" id="inputData" name="inputData">
                            </div>
                        </div>

                    </div>

                    <div class="row text-center">
                        <button type="button" id="btnPesquisar" class="btn btn-default"><i class="fa fa-search"></i> <strong>PESQUISAR</strong></button>
                    </div>
	            </div>
            </div>

            <div class="modal-footer">
                
                    <div class="row table-responsive" style="position: relative; height: 350px;">
                        <table class="table table-hover table-bordered">
                            <thead style="background-color: #182226; color: #FFF">
                                <tr>
                                    <th style="width: 3%;" class="text-center">#ID</th>
                                    <th class="text-center">FORNECEDOR</th>
                                    <th class="text-center">Nº DA NOTA</th>
                                    <th class="text-center">SETOR</th>
                                    <th class="text-center">DATA DE ENTRADA</th>
                                    <th style="width: 10%;" class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody id="listaDeLancamentos">   
                                <tr>
                                    <td colspan="6" class="text-center">Nenhum Registro Encontrado...</td>
                                </tr>             
                            </tbody>
                        </table>
                    </div>
                
            </div>

            

        </div>
   	</div>
</div>

<!-- Modal Imprimir Relatorio -->
<div class="modal fade" id="modalImprimirRelatorio" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog">
    	<div class="modal-content">
        	<div class="modal-header text-center" style="background-color: #188b26; color:#FFFFFF">
                   
                <h4 class="modal-title">IMPRIMIR RELATÓRIO</h4>
            </div>

            <div class="modal-body">
	            <div class="box-body" id="divImprimir">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group" id="groupInputTituloRelatorio">
                                <label for="inputTituloRelatorio">TÍTULO DO RELATÓRIO:</label>
                                <input type="text" class="form-control" id="inputTituloRelatorio" name="inputTituloRelatorio" placeholder="Digite o título do relatório...">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group" id="groupInputDataRelatorio">
                                <label for="inputDataRelatorio">DATA RELATÓRIO:</label>
                                <input type="date" class="form-control" id="inputDataRelatorio" name="inputDataRelatorio">
                            </div>
                        </div>
                    </div>
	            </div>

                <div class="box-footer text-center">
                  	<button type="button" class="btn btn-default btn-flat" id="btnRelatorioImprimir" style="background-color: #21ae32; color: #FFFFFF;"><i class="fa fa-print"></i> <strong>IMPRIMIR</strong></button>
                    <button type="button" class="btn btn-default btn-flat" id="btnRelatorioCancelar" style="background-color: #f6f9f5;"><i class="fa fa-remove"></i> <strong>CANCELAR</strong></button>
                </div>
            </div>
        </div>
   	</div>
</div>
