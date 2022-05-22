let dadosSetor = [];

let btnCancelar = document.getElementById('btnCancelar');
let btnSalvar = document.getElementById('btnSalvar');
let tableBodySetores = document.getElementById('tableBodySetores');
let inputBuscarSetor = document.getElementById('inputBuscarSetor');

btnCancelar.addEventListener('click', fecharModal);
btnSalvar.addEventListener('click', saveDados);

inputBuscarSetor.addEventListener('keyup', searchDados);

function getAllDados() {

    $.ajax({
        url : "./ajaxController/requisicoesAjax",
        type : 'POST',
        dataType: 'json',
        data : {tabela:'setores', metodo:'getAllSetores'},
        success : function(data){ 

            let lista = ``;
            let count = 1;

            dadosSetor = data;

            if(dadosSetor.length != 0) {
                for(let index = 0; index < dadosSetor.length; index++) {
                    lista += `<tr>
                                <td class="text-center">${count++}</td>
                                <td class="text-center text-bold">${dadosSetor[index]['nome_setor']}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-default btn-sm" onClick="updateDados(${dadosSetor[index]['id_setor']})"><i class="fa fa-pencil"></i></button> 
                                    <button type="button" class="btn btn-default btn-sm" onclick="deleteDados(${dadosSetor[index]['id_setor']})"><i class="fa fa-trash"></i></button>
                                </td>
                              </tr>`;
                }

            }else {
                lista += `<tr>
                            <td colspan="3" class="text-center">Nenhum Registro Encontrado...</td>
                          </tr>`;
            }

            tableBodySetores.innerHTML = lista;
        }
    });
}

function searchDados() {
    let setores = [];

    let lista = ``;
    let count = 1;

    for(let set of dadosSetor) {
        if(set.nome_setor.toLocaleUpperCase().indexOf(inputBuscarSetor.value.toLocaleUpperCase()) >= 0) {
            setores.push(set);
        }
    }

    if(setores.length != 0) {
        for(let index = 0; index < setores.length; index++) {
            lista += `<tr>
                        <td class="text-center">${count++}</td>
                        <td class="text-center text-bold">${setores[index]['nome_setor']}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-default btn-sm" onClick="updateDados(${setores[index]['id_setor']})"><i class="fa fa-pencil"></i></button> 
                            <button type="button" class="btn btn-default btn-sm" onclick="deleteDados(${setores[index]['id_setor']})"><i class="fa fa-trash"></i></button>
                        </td>
                      </tr>`;
        }
    }else {
        lista += `<tr>
                    <td colspan="3" class="text-center">Nenhum Registro Encontrado...</td>
                  </tr>`;
    }

    tableBodySetores.innerHTML = lista;
}

function saveDados() {
    
    let dados = {nome:document.getElementById('inputNomeSetor').value, id:document.getElementById('inputIdSetor').value};

    $.ajax({
        url : "./ajaxController/requisicoesAjax",
        type : 'POST',
        dataType: 'json',
        data : {tabela:'setores', metodo:'save', dados:dados},
        beforeSend: function(){
            $('#modalCadastrarSetor *').prop('disabled',true);
        },
        success : function(data){
            if(data['status']) {
                fecharModal();
                getAllDados();
                mensagemAlerta(1, data['mensagem']);
            }else {
                document.getElementById('bodyModalCadastro').innerHTML = ` <div class="form-group">
                                                                                <label for="inputNomeSetor">NOME DO SETOR:</label>
                                                                                <input type="text" class="form-control" id="inputNomeSetor" required="true" name="inputNomeSetor" placeholder="Digite o nome do setor..." style="border-color:#dd4b39;">
                                                                                <input type="hidden" id="inputIdSetor" name="inputIdSetor" value="${document.getElementById('inputIdSetor').value}">
                                                                                <small class="text-red">* ${data['mensagem']['nome_setor']} </small>
                                                                           </div>`;
            }

            $('#modalCadastrarSetor *').prop('disabled',false);
        }
    });
}

function updateDados(value) {
    let setores = [];

    for(let set of dadosSetor) {
        if(set.id_setor.indexOf(value) >= 0) {
            setores.push(set);
        }
    }

    document.getElementById('headerModalCadastro').innerHTML = `<h4 class="modal-title">EDITAR SETOR</h4>`;

    document.getElementById('bodyModalCadastro').innerHTML = ` <div class="form-group">
                                                                    <label for="inputNomeSetor">NOME DO SETOR:</label>
                                                                    <input type="text" class="form-control" id="inputNomeSetor" required="true" name="inputNomeSetor" value="${setores[0]['nome_setor']}" placeholder="Digite o nome do setor...">
                                                                    <input type="hidden" id="inputIdSetor" name="inputIdSetor" value="${setores[0]['id_setor']}">
                                                                </div>`;

    $('#modalCadastrarSetor').modal('show');
}

function deleteDados(value) {
    
    if(confirm('Deseja Excluir esse SETOR?')) {
        let dados = {id:value};

        $.ajax({
            url : "./ajaxController/requisicoesAjax",
            type : 'POST',
            dataType: 'json',
            data : {tabela:'setores', metodo:'delete', dados:dados},
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

function fecharModal() {
    $('#modalCadastrarSetor').modal('hide');

    document.getElementById('headerModalCadastro').innerHTML = `<h4 class="modal-title">CADASTRAR SETOR</h4>`;

    document.getElementById('bodyModalCadastro').innerHTML = ` <div class="form-group">
                                                                    <label for="inputNomeSetor">NOME DO SETOR:</label>
                                                                    <input type="text" class="form-control" id="inputNomeSetor" required="true" name="inputNomeSetor" placeholder="Digite o nome do setor...">
                                                                    <input type="hidden" id="inputIdSetor" name="inputIdSetor" value="0">
                                                                </div>`;
}

getAllDados();