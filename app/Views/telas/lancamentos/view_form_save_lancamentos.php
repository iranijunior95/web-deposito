<div class="container">
    <br>
    <div class="box box-solid" id="divConteudo">
        <div class="box-header text-center" style="background-color: #008d4c; color:#FFFFFF">
            <h2><i class="fa fa-file-text"></i> CADASTRAR LANÇAMENTO</h2>
        </div>
        
        <div class="box-body">

            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="inputFornecedor">FORNECEDOR:</label>
                        <select class="form-control select2" style="width: 100%;" id="inputFornecedor" name="inputFornecedor">
                            
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

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="inputConferente">CONFERENTE:</label>
                        <select class="form-control select2" style="width: 100%;" id="inputConferente" name="inputConferente">
                           
                           <?php
                            foreach($conferentes as $conf) {
                            ?>
                            <option value="<?=$conf['id_conferente']?>"><?=$conf['nome_conferente']?></option>
                            <?php
                            }
                            ?>

                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="inputSetor">SETOR:</label>
                        <select class="form-control" id="inputSetor" name="inputSetor">
                            
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
            </div>

            <div class="row">
                <div class="col-md-4" id="campoNumeroDaNota">
                    <div class="form-group">
					    <label for="inputNumeroDaNota">Nº DA NOTA:</label>
                        <input type="number" class="form-control" id="inputNumeroDaNota" name="inputNumeroDaNota" placeholder="Digite o número da nota...">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group" id="campoValorDaNota">
					    <label for="inputValorDaNota">VALOR DA NOTA:</label>
                        <input type="text" class="form-control" id="inputValorDaNota" name="inputValorDaNota" placeholder="R$ 0,00">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
					    <label for="inputPesoDaNota">PESO DA NOTA:</label>
                        <input type="text" class="form-control" id="inputPesoDaNota" name="inputPesoDaNota" placeholder="0.000 kg">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8" id="campoNomeDoMotorista">
                    <div class="form-group">
					    <label for="inputNomeMotorista">NOME DO MOTORISTA:</label>
                        <input type="text" class="form-control" id="inputNomeMotorista" name="inputNomeMotorista" placeholder="Digite o nome do motorista...">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="inputPlacaVeiculo">PLACA DO VEÍCULO:</label>
                        <input type="text" class="form-control" id="inputPlacaVeiculo" name="inputPlacaVeiculo" placeholder="Digite a placa do veículo...">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
					    <label for="inputTaxaDescarrego">TAXA DE DESCARREGO:</label>
                        <input type="text" class="form-control" id="inputTaxaDescarrego" name="inputTaxaDescarrego" placeholder="R$ 0,00">
                    </div>
                </div>

                <div class="col-md-3" id="campoHoraDeEntrada">
                    <div class="form-group">
					    <label for="inputHoraEntrada">HORA DE ENTRADA:</label>
                        <input type="time" class="form-control" id="inputHoraEntrada" name="inputHoraEntrada" placeholder="00:00 Hs">
                    </div>
                </div>

                <div class="col-md-3" id="campoHoraDeSaida">
                    <div class="form-group">
					    <label for="inputHoraSaida">HORA DE SAÍDA:</label>
                        <input type="time" class="form-control" id="inputHoraSaida" name="inputHoraSaida" placeholder="00:00 Hs">
                    </div>
                </div>

                <div class="col-md-3" id="campoDataDeEntrada">
                    <div class="form-group">
					    <label for="inputDataEntrada">DATA DE ENTRADA:</label>
                        <input type="date" class="form-control" id="inputDataEntrada" name="inputDataEntrada">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="hidden" id="inputId" name="inputId" value="0">
                    </div>
                </div>
            </div>

        </div>

        <div class="box-footer text-center">
            <button type="button" class="btn btn-default btn-flat" id="btnSalvar" value="0" style="background-color: #21ae32; color: #FFFFFF;"><i class="fa fa-check"></i> <strong>SALVAR</strong></button>
            <button type="button" class="btn btn-default btn-flat" id="btnCancelar" style="background-color: #f6f9f5;"><i class="fa fa-remove"></i> <strong>CANCELAR</strong></button>
        </div>
    </div>
</div>