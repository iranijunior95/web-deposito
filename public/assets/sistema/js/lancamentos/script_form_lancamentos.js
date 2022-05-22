let btnSalvar = document.getElementById('btnSalvar');
let btnCancelar = document.getElementById('btnCancelar');

btnSalvar.addEventListener('click', saveDados);
btnCancelar.addEventListener('click', ()=>{window.location.href = '../lancamentos'});

function saveDados() {
    let dados = {
        fornecedor: document.getElementById('inputFornecedor').value,
        conferente: document.getElementById('inputConferente').value,
        setor: document.getElementById('inputSetor').value,
        numeroNota: document.getElementById('inputNumeroDaNota').value,
        valorNota: document.getElementById('inputValorDaNota').value,
        pesoNota: document.getElementById('inputPesoDaNota').value,
        nomeMotorista: document.getElementById('inputNomeMotorista').value,
        placaVeiculo: document.getElementById('inputPlacaVeiculo').value,
        taxaDescarrego: document.getElementById('inputTaxaDescarrego').value,
        horaEntrada: document.getElementById('inputHoraEntrada').value,
        horaSaida: document.getElementById('inputHoraSaida').value,
        dataEntrada: document.getElementById('inputDataEntrada').value,
        id: document.getElementById('inputId').value
    };

    let url = '';

    if(btnSalvar.value == 1) {
        url = "../../ajaxController/requisicoesAjax";
    }else {
        url = "../ajaxController/requisicoesAjax";
    }

    $.ajax({
        url : url,
        type : 'POST',
        dataType: 'json',
        data : {tabela:'lancamentos', metodo:'save', dados:dados},
        beforeSend: function(){
            $('#divConteudo *').prop('disabled',true);
        },
        success : function(data){
            if(data['status']) {
                if(btnSalvar.value == 1) {
                    window.location.href = `../detalhes/${data['id_lancamento']}`
                }else {
                    window.location.href = `../lancamentos/detalhes/${data['id_lancamento']}`
                }
            }else {
                exibirMensagenDeErro('numero_nota', data['mensagem']['numero_nota']);
                exibirMensagenDeErro('valor_nota', data['mensagem']['valor_nota']);
                exibirMensagenDeErro('nome_motorista', data['mensagem']['nome_motorista']);
                exibirMensagenDeErro('hora_entrada', data['mensagem']['hora_entrada']);
                exibirMensagenDeErro('hora_saida', data['mensagem']['hora_saida']);
                exibirMensagenDeErro('data_entrada', data['mensagem']['data_entrada']);
            }

            $('#divConteudo *').prop('disabled',false);
        }

    });
}

function exibirMensagenDeErro(campo, mensagem) {
    switch (campo) {
        case 'numero_nota':
            if(mensagem) {
                document.getElementById('campoNumeroDaNota').innerHTML = `<div class="form-group">
                                                                                <label for="inputNumeroDaNota">Nº DA NOTA:</label>
                                                                                <input type="number" class="form-control" id="inputNumeroDaNota" name="inputNumeroDaNota" placeholder="Digite o número da nota..." value="${document.getElementById('inputNumeroDaNota').value}" style="border-color:#dd4b39;">
                                                                                <small class="text-red">* ${mensagem} </small>
                                                                            </div>`;
            }else {
                document.getElementById('campoNumeroDaNota').innerHTML = `<div class="form-group">
                                                                                <label for="inputNumeroDaNota">Nº DA NOTA:</label>
                                                                                <input type="number" class="form-control" id="inputNumeroDaNota" name="inputNumeroDaNota" placeholder="Digite o número da nota..." value="${document.getElementById('inputNumeroDaNota').value}">
                                                                            </div>`;
            }
            break;

        case 'valor_nota':
            if(mensagem) {
                document.getElementById('inputValorDaNota').style.borderColor = '#dd4b39';
                if(document.getElementById('mensagemErrorValorNota')) {
                    document.getElementById('mensagemErrorValorNota').remove();
                }
                document.getElementById('campoValorDaNota').insertAdjacentHTML('beforeend', `<small class="text-red" id="mensagemErrorValorNota">* ${mensagem} </small>`);
            }else {
                document.getElementById('inputValorDaNota').style.borderColor = '#d2d6de';
                if(document.getElementById('mensagemErrorValorNota')) {
                    document.getElementById('mensagemErrorValorNota').remove();
                }
            }
            break;
            
        case 'nome_motorista':
            if(mensagem) {
                document.getElementById('campoNomeDoMotorista').innerHTML = `<div class="form-group">
                                                                                <label for="inputNomeMotorista">NOME DO MOTORISTA:</label>
                                                                                <input type="text" class="form-control" id="inputNomeMotorista" name="inputNomeMotorista" placeholder="Digite o nome do motorista..." value="${document.getElementById('inputNomeMotorista').value}" style="border-color:#dd4b39;">
                                                                                <small class="text-red">* ${mensagem} </small>
                                                                            </div>`;
            }else {
                document.getElementById('campoNomeDoMotorista').innerHTML = `<div class="form-group">
                                                                                <label for="inputNomeMotorista">NOME DO MOTORISTA:</label>
                                                                                <input type="text" class="form-control" id="inputNomeMotorista" name="inputNomeMotorista" placeholder="Digite o nome do motorista..." value="${document.getElementById('inputNomeMotorista').value}">
                                                                            </div>`;
            }
            break;

        case 'hora_entrada':
            if(mensagem) {
                document.getElementById('campoHoraDeEntrada').innerHTML = `<div class="form-group">
                                                                                <label for="inputHoraEntrada">HORA DE ENTRADA:</label>
                                                                                <input type="time" class="form-control" id="inputHoraEntrada" name="inputHoraEntrada" placeholder="00:00 Hs" value="${document.getElementById('inputHoraEntrada').value}" style="border-color:#dd4b39;">
                                                                                <small class="text-red">* ${mensagem} </small>
                                                                            </div>`;
            }else {
                document.getElementById('campoHoraDeEntrada').innerHTML = `<div class="form-group">
                                                                                <label for="inputHoraEntrada">HORA DE ENTRADA:</label>
                                                                                <input type="time" class="form-control" id="inputHoraEntrada" name="inputHoraEntrada" placeholder="00:00 Hs" value="${document.getElementById('inputHoraEntrada').value}">
                                                                            </div>`;
            }
            break;

        case 'hora_saida':
            if(mensagem) {
                document.getElementById('campoHoraDeSaida').innerHTML = `<div class="form-group">
                                                                                <label for="inputHoraSaida">HORA DE SAÍDA:</label>
                                                                                <input type="time" class="form-control" id="inputHoraSaida" name="inputHoraSaida" placeholder="00:00 Hs" value="${document.getElementById('inputHoraSaida').value}" style="border-color:#dd4b39;">
                                                                                <small class="text-red">* ${mensagem} </small>
                                                                            </div>`;
            }else {
                document.getElementById('campoHoraDeSaida').innerHTML = `<div class="form-group">
                                                                                <label for="inputHoraSaida">HORA DE SAÍDA:</label>
                                                                                <input type="time" class="form-control" id="inputHoraSaida" name="inputHoraSaida" placeholder="00:00 Hs" value="${document.getElementById('inputHoraSaida').value}">
                                                                            </div>`;
            }
            break;

        case 'data_entrada':
            if(mensagem) {
                document.getElementById('campoDataDeEntrada').innerHTML = `<div class="form-group">
                                                                                <label for="inputDataEntrada">DATA DE ENTRADA:</label>
                                                                                <input type="date" class="form-control" id="inputDataEntrada" name="inputDataEntrada" value="${document.getElementById('inputDataEntrada').value}" style="border-color:#dd4b39;">
                                                                                <small class="text-red">* ${mensagem} </small>
                                                                            </div>`;
            }else {
                document.getElementById('campoDataDeEntrada').innerHTML = `<div class="form-group">
                                                                                <label for="inputDataEntrada">DATA DE ENTRADA:</label>
                                                                                <input type="date" class="form-control" id="inputDataEntrada" name="inputDataEntrada" value="${document.getElementById('inputDataEntrada').value}">
                                                                            </div>`;
            }
            break;
    }
}

//Formatar campos
document.getElementById('inputValorDaNota').addEventListener('keyup', function() {
	var v = this.value.replace(/\D/g,'');
	v = (v/100).toFixed(2) + '';
	v = v.replace(".", ",");
	v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
	v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
	this.value = v;
});

$('#inputTaxaDescarrego').keyup(function() {
	var v = this.value.replace(/\D/g,'');
	v = (v/100).toFixed(2) + '';
	v = v.replace(".", ",");
	v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
	v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
	this.value = v;
});

$('#inputPesoDaNota').keyup(function () {
	var v = this.value,
	integer = v.split('.')[0];

	v = v.replace(/\D/g, "");

	v = v.replace(/^[0]+/, "");

	if (v.length <= 3 || !integer) {

		if (v.length === 1) v = '0.00' + v;

		if (v.length === 2) v = '0.0' + v;

		if (v.length === 3) v = '0.' + v;
	} else {
		v = v.replace(/^(\d{1,})(\d{3})$/, "$1.$2");
	}
this.value = v;

});