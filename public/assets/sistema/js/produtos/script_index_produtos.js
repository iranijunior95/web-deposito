let dadosProdutos = [];

let btnCancelar = document.getElementById('btnCancelar');
let btnSalvar = document.getElementById('btnSalvar');
let tableBodyProdutos = document.getElementById('tableBodyProdutos');
let inputBuscarProduto = document.getElementById('inputBuscarProduto');

btnCancelar.addEventListener('click', fecharModal);
btnSalvar.addEventListener('click', saveDados);

inputBuscarProduto.addEventListener('keyup', searchDados);

function saveDados() {
    let dados = {nome:document.getElementById('inputNomeProduto').value, codigo:document.getElementById('inputCodProduto').value, id:document.getElementById('inputIdProduto').value};

    $.ajax({
        url : "./ajaxController/requisicoesAjax",
        type : 'POST',
        dataType: 'json',
        data : {tabela:'produtos', metodo:'save', dados:dados},
        beforeSend: function(){
            $('#modalCadastrarProduto *').prop('disabled',true);
        },
        success : function(data){
            if(data['status']) {
                fecharModal();
                getAllDados();
                mensagemAlerta(1, data['mensagem']);
            }else {
                if(data['mensagem']['nome_produto'] && data['mensagem']['cod_produto']) {
                    document.getElementById('bodyModalCadastro').innerHTML = ` <div class="form-group">
                                                                                    <label for="inputNomeProduto">NOME DO PRODUTO:</label>
                                                                                    <input type="text" class="form-control" id="inputNomeProduto" required="true" name="inputNomeProduto" value="${document.getElementById('inputNomeProduto').value}" placeholder="Digite o nome do produto..." style="border-color:#dd4b39;">
                                                                                    <small class="text-red">* ${data['mensagem']['nome_produto']} </small>
                                                                                </div>
                                                                           
                                                                                <div class="form-group">
                                                                                    <label for="inputCodProduto">CÓDIGO DO PRODUTO:</label>
                                                                                    <input type="number" class="form-control" id="inputCodProduto" required="true" name="inputCodProduto" value="${document.getElementById('inputCodProduto').value}" placeholder="Digite o código do produto..." style="border-color:#dd4b39;">
                                                                                    <small class="text-red">* ${data['mensagem']['cod_produto']} </small>
                                                                                </div>
                                                                           
                                                                                <input type="hidden" id="inputIdProduto" name="inputIdProduto" value="${document.getElementById('inputIdProduto').value}">`;

                }else if(!data['mensagem']['nome_produto'] && data['mensagem']['cod_produto']) {
                    document.getElementById('bodyModalCadastro').innerHTML = ` <div class="form-group">
                                                                                    <label for="inputNomeProduto">NOME DO PRODUTO:</label>
                                                                                    <input type="text" class="form-control" id="inputNomeProduto" required="true" name="inputNomeProduto" value="${document.getElementById('inputNomeProduto').value}" placeholder="Digite o nome do produto...">
                                                                                </div>
                                                                           
                                                                                <div class="form-group">
                                                                                    <label for="inputCodProduto">CÓDIGO DO PRODUTO:</label>
                                                                                    <input type="number" class="form-control" id="inputCodProduto" required="true" name="inputCodProduto" value="${document.getElementById('inputCodProduto').value}" placeholder="Digite o código do produto..." style="border-color:#dd4b39;">
                                                                                    <small class="text-red">* ${data['mensagem']['cod_produto']} </small>
                                                                                </div>
                                                                           
                                                                                <input type="hidden" id="inputIdProduto" name="inputIdProduto" value="${document.getElementById('inputIdProduto').value}">`;
                }else {
                    document.getElementById('bodyModalCadastro').innerHTML = ` <div class="form-group">
                                                                                    <label for="inputNomeProduto">NOME DO PRODUTO:</label>
                                                                                    <input type="text" class="form-control" id="inputNomeProduto" required="true" name="inputNomeProduto" value="${document.getElementById('inputNomeProduto').value}" placeholder="Digite o nome do produto..." style="border-color:#dd4b39;">
                                                                                    <small class="text-red">* ${data['mensagem']['nome_produto']} </small>
                                                                                </div>
                                                                           
                                                                                <div class="form-group">
                                                                                    <label for="inputCodProduto">CÓDIGO DO PRODUTO:</label>
                                                                                    <input type="number" class="form-control" id="inputCodProduto" required="true" name="inputCodProduto" value="${document.getElementById('inputCodProduto').value}" placeholder="Digite o código do produto...">
                                                                                </div>
                                                                           
                                                                                <input type="hidden" id="inputIdProduto" name="inputIdProduto" value="${document.getElementById('inputIdProduto').value}">`;
                }
            }

            $('#modalCadastrarProduto *').prop('disabled',false);
        }
    });
}

function updateDados(value) {
    let produtos = [];

    for(let prod of dadosProdutos) {
        if(prod.id_produto.indexOf(value) >= 0) {
            produtos.push(prod);
        }
    }

    document.getElementById('headerModalCadastro').innerHTML = `<h4 class="modal-title">EDITAR PRODUTO</h4>`;

    document.getElementById('bodyModalCadastro').innerHTML = ` <div class="form-group">
                                                                    <label for="inputNomeProduto">NOME DO PRODUTO:</label>
                                                                    <input type="text" class="form-control" id="inputNomeProduto" required="true" name="inputNomeProduto" value="${produtos[0]['nome_produto']}" placeholder="Digite o nome do produto...">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="inputCodProduto">CÓDIGO DO PRODUTO:</label>
                                                                    <input type="number" class="form-control" id="inputCodProduto" required="true" name="inputCodProduto" value="${produtos[0]['cod_produto']}" placeholder="Digite o código do produto...">
                                                                </div>

                                                                <input type="hidden" id="inputIdProduto" name="inputIdProduto" value="${produtos[0]['id_produto']}">`;

    $('#modalCadastrarProduto').modal('show');
}

function deleteDados(value) {
    
    if(confirm('Deseja Excluir esse PRODUTO?')) {
        let dados = {id:value};

        $.ajax({
            url : "./ajaxController/requisicoesAjax",
            type : 'POST',
            dataType: 'json',
            data : {tabela:'produtos', metodo:'delete', dados:dados},
            success : function(data){
                if(data['status']) {
                    mensagemAlerta(1, data['mensagem']);
                    getAllDados();
                }else {
                    mensagemAlerta(0, data['mensagem']);
                }
            }
        });
    }
    
}

function getAllDados() {

    $.ajax({
        url : "./ajaxController/requisicoesAjax",
        type : 'POST',
        dataType: 'json',
        data : {tabela:'produtos', metodo:'getAllProdutos'},
        success : function(data){ 

            let lista = ``;
            let count = 1;

            dadosProdutos = data;

            if(dadosProdutos.length != 0) {
                for(let index = 0; index < dadosProdutos.length; index++) {
                    lista += `<tr>
                                <td class="text-center">${count++}</td>
                                <td class="text-center text-bold">${dadosProdutos[index]['nome_produto']}</td>
                                <td class="text-center">${dadosProdutos[index]['cod_produto']}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-default btn-sm" onClick="updateDados(${dadosProdutos[index]['id_produto']})"><i class="fa fa-pencil"></i></button> 
                                    <button type="button" class="btn btn-default btn-sm" onclick="deleteDados(${dadosProdutos[index]['id_produto']})"><i class="fa fa-trash"></i></button>
                                </td>
                              </tr>`;
                }

            }else {
                lista += `<tr>
                            <td colspan="4" class="text-center">Nenhum Registro Encontrado...</td>
                          </tr>`;
            }

            tableBodyProdutos.innerHTML = lista;
        }
    });
}

function searchDados() {
    let produtos = [];

    let lista = ``;
    let count = 1;

    for(let prod of dadosProdutos) {
        if(prod.nome_produto.toLocaleUpperCase().indexOf(inputBuscarProduto.value.toLocaleUpperCase()) >= 0) {
            produtos.push(prod);
        }
    }

    if(produtos.length != 0) {
        for(let index = 0; index < produtos.length; index++) {
            lista += `<tr>
                        <td class="text-center">${count++}</td>
                        <td class="text-center text-bold">${produtos[index]['nome_produto']}</td>
                        <td class="text-center">${produtos[index]['cod_produto']}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-default btn-sm" onClick="updateDados(${produtos[index]['id_produto']})"><i class="fa fa-pencil"></i></button> 
                            <button type="button" class="btn btn-default btn-sm" onclick="deleteDados(${produtos[index]['id_produto']})"><i class="fa fa-trash"></i></button>
                        </td>
                      </tr>`;
        }
    }else {
        lista += `<tr>
                    <td colspan="4" class="text-center">Nenhum Registro Encontrado...</td>
                  </tr>`;
    }

    tableBodyProdutos.innerHTML = lista;
}

function fecharModal() {
    $('#modalCadastrarProduto').modal('hide');

    document.getElementById('headerModalCadastro').innerHTML = `<h4 class="modal-title">CADASTRAR PRODUTO</h4>`;

    document.getElementById('bodyModalCadastro').innerHTML = ` <div class="form-group">
                                                                    <label for="inputNomeProduto">NOME DO PRODUTO:</label>
                                                                    <input type="text" class="form-control" id="inputNomeProduto" required="true" name="inputNomeProduto" placeholder="Digite o nome do produto...">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="inputCodProduto">CÓDIGO DO PRODUTO:</label>
                                                                    <input type="number" class="form-control" id="inputCodProduto" required="true" name="inputCodProduto" placeholder="Digite o código do produto...">
                                                                </div>

                                                                <input type="hidden" id="inputIdProduto" name="inputIdProduto" value="0">`;
}

getAllDados();