<div class="container">

    <br>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body text-center" style="background-color: #008d4c; color:#FFFFFF">
                    <h2><i class="fa fa-cubes"></i> PRODUTOS</h2>
                </div>
                <div class="box-footer text-center">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group h7">
                                <input name="inputBuscarProduto" class="form-control" id="inputBuscarProduto" type="text" placeholder="Buscar Produto...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default btn-flat" type="submit" disabled="true">
                                    <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-4"></div>

                        <div class="col-md-4">
                            <button type="button" class="btn btn-default btn-flat pull-right h7" data-toggle="modal" data-target="#modalCadastrarProduto"><i class="fa fa-plus"></i> <b>CADASTRAR NOVO</b></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-solid">
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover table-bordered">
                <thead style="background-color: #1f1b1b; color: #FFFFFF">
                    <tr>
                        <th style="width: 3%;" class="text-center">#ID</th>
                        <th class="text-center">PRODUTOS</th>
                        <th style="width: 15%;" class="text-center">CÓDIGO PRODUTO</th>
                        <th style="width: 10%;" class="text-center">DETALHES</th>
                    </tr>
                </thead>

                <tbody id="tableBodyProdutos">
                    <tr>
                        <td colspan="4" class="text-center"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Cadastro de PRODUTOS -->
<div class="modal fade" id="modalCadastrarProduto" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog">
    	<div class="modal-content">
        	<div class="modal-header text-center" id="headerModalCadastro" style="background-color: #188b26; color:#FFFFFF">
                <h4 class="modal-title">CADASTRAR PRODUTO</h4>
            </div>

            <div class="modal-body">
	            <div class="box-body" id="bodyModalCadastro">
				    <div class="form-group">
						<label for="inputNomeProduto">NOME DO PRODUTO:</label>
						<input type="text" class="form-control" id="inputNomeProduto" required="true" name="inputNomeProduto" placeholder="Digite o nome do produto...">
                    </div>

                    <div class="form-group">
						<label for="inputCodProduto">CÓDIGO DO PRODUTO:</label>
						<input type="number" class="form-control" id="inputCodProduto" required="true" name="inputCodProduto" placeholder="Digite o código do produto...">
                    </div>

                    <input type="hidden" id="inputIdProduto" name="inputIdProduto" value="0">
	            </div>

	            <div class="box-footer text-center">
                    <button type="button" class="btn btn-default btn-flat" id="btnSalvar" style="background-color: #21ae32; color: #FFFFFF;"><i class="fa fa-check"></i> <strong>SALVAR</strong></button>
                    <button type="button" class="btn btn-default btn-flat" id="btnCancelar" style="background-color: #f6f9f5;"><i class="fa fa-remove"></i> <strong>CANCELAR</strong></button>
                </div>
            </div>
        </div>
   	</div>
</div>