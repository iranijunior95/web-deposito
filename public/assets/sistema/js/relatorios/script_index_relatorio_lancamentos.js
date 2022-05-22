let dadosLancamento = [];
let dadosRelatorio = [];

let btnPesquisar = document.getElementById('btnPesquisar');
let btnRelatorioImprimir = document.getElementById('btnRelatorioImprimir');
let btnRelatorioCancelar = document.getElementById('btnRelatorioCancelar');
let listaDeLancamentos = document.getElementById('listaDeLancamentos');
let listaDeLancamentoRelatorio = document.getElementById('listaDeLancamentoRelatorio');

btnRelatorioCancelar.addEventListener('click', () => {
    document.getElementById('groupInputTituloRelatorio').innerHTML = `<label for="inputTituloRelatorio">TÍTULO DO RELATÓRIO:</label>
                                                                      <input type="text" class="form-control" id="inputTituloRelatorio" name="inputTituloRelatorio" placeholder="Digite o título do relatório...">`;

    document.getElementById('groupInputDataRelatorio').innerHTML = `<label for="inputDataRelatorio">DATA RELATÓRIO:</label>
                                                                    <input type="date" class="form-control" id="inputDataRelatorio" name="inputDataRelatorio">`;
    $('#modalImprimirRelatorio').modal('hide');
});

btnRelatorioImprimir.addEventListener('click', imprimirRelatorio);

btnPesquisar.addEventListener('click', pesquisarLancamentos);

function pesquisarLancamentos() {
    let dados = {
        inputFornecedor: document.getElementById('inputFornecedor').value,
        inputNumeroDaNota: document.getElementById('inputNumeroDaNota').value,
        inputConferente: 0,
        inputSetor: document.getElementById('inputSetor').value,
        inputData: document.getElementById('inputData').value
    };

    $.ajax({
        url : "../ajaxController/requisicoesAjax",
        type : 'POST',
        dataType: 'json',
        data : {tabela:'lancamentos', metodo:'pesquisarLancamentos', dados:dados},
        beforeSend: function(){
            $('#divPesquisa *').prop('disabled',true);

            listaDeLancamentos.innerHTML = `<tr>
                                                <td colspan="6" class="text-center">Pesquisando...</td>
                                            </tr>`;
        },
        success : function(data){
            let lista = ``;
            let count = 1;

            dadosLancamento = data;
            
            if(dadosLancamento.length != 0) {
                for(let index = 0; index < dadosLancamento.length; index++) {
                    data = new Date(dadosLancamento[index]['data_entrada']);

                    lista += `<tr>
                                <td class="text-center">${count++}</td>
                                <td class="text-center text-bold text-blue">${dadosLancamento[index]['nome_fornecedor']}</td>
                                <td class="text-center">${dadosLancamento[index]['numero_nota']}</td>
                                <td class="text-center">${dadosLancamento[index]['nome_setor']}</td>
                                <td class="text-center">${data.toLocaleDateString('pt-BR', {timeZone: 'UTC'})}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-default btn-xs" onclick="addLancamentoLista(${dadosLancamento[index]['id_lancamento']})"><i class="fa fa-plus"></i></button>
                                </td>
                              </tr>`;
                }

                lista += `<tr>
                            <td colspan="6" class="text-center">
                                <button type="button" class="btn btn-default btn-xs" onclick="addAllLancamentoLista()"><i class="fa fa-plus"></i> ADICIONAR TODOS</button>
                            </td>
                          </tr>`;

            }else {
                lista += `<tr>
                            <td colspan="6" class="text-center">Nenhum Registro Encontrado...</td>
                          </tr>`;
            }

            listaDeLancamentos.innerHTML = lista;
            $('#divPesquisa *').prop('disabled',false);
        }

        

    });
}

function addLancamentoLista(value) {
    
    let result = dadosLancamento.find(lancamento => lancamento.id_lancamento === String(value));
    dadosRelatorio.push(result)

    atualizaListaRelatorio();

}

function addAllLancamentoLista() {
    dadosLancamento.forEach(function(lancamento) {
        dadosRelatorio.push(lancamento)
    });

    atualizaListaRelatorio()
}

function removerLancamento(indice) {
    
    dadosRelatorio.splice(indice, 1)
    atualizaListaRelatorio()
}

function moverParaCima(indice) {
    let posicaoAtual = indice
    let posicaoFutura = indice-1

    if(posicaoAtual == 0) {
        posicaoFutura = 0
    }
    dadosRelatorio.splice(posicaoFutura, 0, dadosRelatorio.splice(posicaoAtual, 1)[0])

    atualizaListaRelatorio()
}

function moverParaBaixo(indice) {
    let posicaoAtual = indice
    let posicaoFutura = indice+1

    dadosRelatorio.splice(posicaoFutura, 0, dadosRelatorio.splice(posicaoAtual, 1)[0])

    atualizaListaRelatorio()
}

function atualizaListaRelatorio () {
    dadosRelatorio = dadosRelatorio.filter(function (a) {
        return !this[JSON.stringify(a)] && (this[JSON.stringify(a)] = true);
    }, Object.create(null));

    listaDeLancamentoRelatorio.innerHTML = ``;
    let count = 1;
    let indice = 0;

    if(dadosRelatorio.length != 0) {
        dadosRelatorio.find(object =>{

            let data = new Date(object.data_entrada);

            listaDeLancamentoRelatorio.innerHTML += `<tr>
                                                        <td class="text-center">${count++}</td>
                                                        <td class="text-center">${object.nome_fornecedor}</td>
                                                        <td class="text-center">${object.numero_nota}</td>
                                                        <td class="text-center">${object.valor_nota}</td>
                                                        <td class="text-center">${object.nome_conferente}</td>
                                                        <td class="text-center">${data.toLocaleDateString('pt-BR', {timeZone: 'UTC'})}</td>
                                                        <td class="text-center">${object.hora_entrada}</td>
                                                        <td class="text-center">${object.hora_saida}</td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-default btn-xs" onclick="moverParaCima(${indice})"><i class="glyphicon glyphicon-arrow-up"></i></button>
                                                            <button type="button" class="btn btn-default btn-xs" onclick="moverParaBaixo(${indice})"><i class="glyphicon glyphicon-arrow-down"></i></button>
                                                            <button type="button" class="btn btn-default btn-xs" onclick="removerLancamento(${indice})"><i class="fa fa-remove"></i></button>
                                                        </td>
                                                    </tr>`;

            indice++
        });

        listaDeLancamentoRelatorio.innerHTML += `<tr>
                                                    <td colspan="10" class="text-center">
                                                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalImprimirRelatorio"><i class="fa fa-print"></i> IMPRIMIR RELATÓRIO</button>
                                                    </td>
                                                </tr>`;
    }else {
        listaDeLancamentoRelatorio.innerHTML += `<tr>
                                                    <td colspan="10" class="text-center">Relatório Vazio</td>
                                                 </tr>`;
    }

    
}

function imprimirRelatorio() {
    if(document.getElementById('inputTituloRelatorio').value === '' && document.getElementById('inputDataRelatorio').value != '') {
        
        document.getElementById('groupInputTituloRelatorio').innerHTML = `<label for="inputTituloRelatorio">TÍTULO DO RELATÓRIO:</label>
                                                                          <input type="text" class="form-control" id="inputTituloRelatorio" name="inputTituloRelatorio" placeholder="Digite o título do relatório..." style="border-color:#dd4b39;">
                                                                          <small class="text-red">* Digite o título do relatório...</small>`;

        document.getElementById('groupInputDataRelatorio').innerHTML = `<label for="inputDataRelatorio">DATA RELATÓRIO:</label>
                                                                        <input type="date" class="form-control" id="inputDataRelatorio" name="inputDataRelatorio" value="${document.getElementById('inputDataRelatorio').value}">`;

    }else if(document.getElementById('inputDataRelatorio').value === '' && document.getElementById('inputTituloRelatorio').value != '') {
        
        document.getElementById('groupInputTituloRelatorio').innerHTML = `<label for="inputTituloRelatorio">TÍTULO DO RELATÓRIO:</label>
                                                                          <input type="text" class="form-control" id="inputTituloRelatorio" name="inputTituloRelatorio" placeholder="Digite o título do relatório..." value="${document.getElementById('inputTituloRelatorio').value}">`;

        document.getElementById('groupInputDataRelatorio').innerHTML = `<label for="inputDataRelatorio">DATA RELATÓRIO:</label>
                                                                        <input type="date" class="form-control" id="inputDataRelatorio" name="inputDataRelatorio" value="${document.getElementById('inputDataRelatorio').value}" style="border-color:#dd4b39;">
                                                                        <small class="text-red">* Digite a data do relatório...</small>`;

    }else if(document.getElementById('inputTituloRelatorio').value === '' && document.getElementById('inputDataRelatorio').value === '') {
        
        document.getElementById('groupInputTituloRelatorio').innerHTML = `<label for="inputTituloRelatorio">TÍTULO DO RELATÓRIO:</label>
                                                                          <input type="text" class="form-control" id="inputTituloRelatorio" name="inputTituloRelatorio" placeholder="Digite o título do relatório..." style="border-color:#dd4b39;">
                                                                          <small class="text-red">* Digite o título do relatório...</small>`;

        document.getElementById('groupInputDataRelatorio').innerHTML = `<label for="inputDataRelatorio">DATA RELATÓRIO:</label>
                                                                        <input type="date" class="form-control" id="inputDataRelatorio" name="inputDataRelatorio" value="${document.getElementById('inputDataRelatorio').value}" style="border-color:#dd4b39;">
                                                                        <small class="text-red">* Digite a data do relatório...</small>`;

    }else {
        let dados = {titulo:document.getElementById('inputTituloRelatorio').value, data:document.getElementById('inputDataRelatorio').value, lista:dadosRelatorio};

        $.ajax({
            url : "../ajaxController/requisicoesAjax",
            type : 'POST',
            dataType: 'json',
            data : {tabela:'relatorios', metodo:'imprimir', dados:dados},
            beforeSend: function(){
                $('#modalImprimirRelatorio *').prop('disabled',true);
            },
            success : function(data){
                if(data['status']) {
                    window.open('../relatorios/imprimir_relatorio_lancamentos/'+data['id_relatorio'], '_blank');

                    $('#modalImprimirRelatorio *').prop('disabled',false);

                    document.getElementById('groupInputTituloRelatorio').innerHTML = `<label for="inputTituloRelatorio">TÍTULO DO RELATÓRIO:</label>
                                                                      <input type="text" class="form-control" id="inputTituloRelatorio" name="inputTituloRelatorio" placeholder="Digite o título do relatório...">`;

                    document.getElementById('groupInputDataRelatorio').innerHTML = `<label for="inputDataRelatorio">DATA RELATÓRIO:</label>
                                                                                    <input type="date" class="form-control" id="inputDataRelatorio" name="inputDataRelatorio">`;
                    $('#modalImprimirRelatorio').modal('hide');
                    
                }else {
                    console.log(data['status'])
                }
            }
        });
    }
}

