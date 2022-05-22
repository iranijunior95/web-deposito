let dadosLancamento = [];

let mensagem = document.getElementById('mensagem');

let btnPesquisar = document.getElementById('btnPesquisar');

let tableBodyLancamentos = document.getElementById('tableBodyLancamentos');

btnPesquisar.addEventListener('click', pesquisarLancamentos);

function getAllDados() {

    $.ajax({
        url : "./ajaxController/requisicoesAjax",
        type : 'POST',
        dataType: 'json',
        data : {tabela:'lancamentos', metodo:'getAllLancamentos'},
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
                                <td class="text-center">${dadosLancamento[index]['nome_conferente']}</td>
                                <td class="text-center">${dadosLancamento[index]['nome_setor']}</td>
                                <td class="text-center">${data.toLocaleDateString('pt-BR', {timeZone: 'UTC'})}</td>
                                <td class="text-center">
                                    <a href="./lancamentos/detalhes/${dadosLancamento[index]['id_lancamento']}" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> DETALHES</a>
                                </td>
                              </tr>`;
                }

            }else {
                lista += `<tr>
                            <td colspan="7" class="text-center">Nenhum Registro Encontrado...</td>
                          </tr>`;
            }

            tableBodyLancamentos.innerHTML = lista;
        }
    });
}

function pesquisarLancamentos() {
    let dados = {
        inputFornecedor: document.getElementById('inputFornecedor').value,
        inputNumeroDaNota: document.getElementById('inputNumeroDaNota').value,
        inputConferente: document.getElementById('inputConferente').value,
        inputSetor: document.getElementById('inputSetor').value,
        inputData: document.getElementById('inputData').value
    };

    $.ajax({
        url : "./ajaxController/requisicoesAjax",
        type : 'POST',
        dataType: 'json',
        data : {tabela:'lancamentos', metodo:'pesquisarLancamentos', dados:dados},
        beforeSend: function(){
            $('#divPesquisa *').prop('disabled',true);

            tableBodyLancamentos.innerHTML = `<tr>
                                                <td colspan="7" class="text-center">Pesquisando...</td>
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
                                <td class="text-center">${dadosLancamento[index]['nome_conferente']}</td>
                                <td class="text-center">${dadosLancamento[index]['nome_setor']}</td>
                                <td class="text-center">${data.toLocaleDateString('pt-BR', {timeZone: 'UTC'})}</td>
                                <td class="text-center">
                                    <a href="./lancamentos/detalhes/${dadosLancamento[index]['id_lancamento']}" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> DETALHES</a>
                                </td>
                              </tr>`;
                }

            }else {
                lista += `<tr>
                            <td colspan="7" class="text-center">Nenhum Registro Encontrado...</td>
                          </tr>`;
            }

            tableBodyLancamentos.innerHTML = lista;
            $('#divPesquisa *').prop('disabled',false);
        }

        

    });
}

if(mensagem.value != 0) {
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: mensagem.value,
        showConfirmButton: false,
    });
}


getAllDados();