let dadosConferente = [];

let btnCancelar = document.getElementById('btnCancelar');
let btnSalvar = document.getElementById('btnSalvar');
let tableBodyConferentes = document.getElementById('tableBodyConferentes');
let inputBuscarConferente = document.getElementById('inputBuscarConferente');

btnCancelar.addEventListener('click', fecharModal);
btnSalvar.addEventListener('click', saveDados);

inputBuscarConferente.addEventListener('keyup', searchDados);

function getAllDados() {

        $.ajax({
            url : "./ajaxController/requisicoesAjax",
            type : 'POST',
            dataType: 'json',
            data : {tabela:'conferentes', metodo:'getAllConferentes'},
            success : function(data){ 

                let lista = ``;
                let count = 1;

                dadosConferente = data;

                if(dadosConferente.length != 0) {
                    for(let index = 0; index < dadosConferente.length; index++) {
                        lista += `<tr>
                                    <td class="text-center">${count++}</td>
                                    <td class="text-center text-bold">${dadosConferente[index]['nome_conferente']}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-default btn-sm" onClick="updateDados(${dadosConferente[index]['id_conferente']})"><i class="fa fa-pencil"></i></button> 
                                        <button type="button" class="btn btn-default btn-sm" onclick="deleteDados(${dadosConferente[index]['id_conferente']})"><i class="fa fa-trash"></i></button>
                                    </td>
                                  </tr>`;
                    }

                }else {
                    lista += `<tr>
                                <td colspan="3" class="text-center">Nenhum Registro Encontrado...</td>
                              </tr>`;
                }

                tableBodyConferentes.innerHTML = lista;
            }
        });
}

function searchDados() {
    let conferentes = [];

    let lista = ``;
    let count = 1;

    for(let conf of dadosConferente) {
        if(conf.nome_conferente.toLocaleUpperCase().indexOf(inputBuscarConferente.value.toLocaleUpperCase()) >= 0) {
            conferentes.push(conf);
        }
    }

    if(conferentes.length != 0) {
        for(let index = 0; index < conferentes.length; index++) {
            lista += `<tr>
                        <td class="text-center">${count++}</td>
                        <td class="text-center text-bold">${conferentes[index]['nome_conferente']}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-default btn-sm" onClick="updateDados(${conferentes[index]['id_conferente']})"><i class="fa fa-pencil"></i></button> 
                            <button type="button" class="btn btn-default btn-sm" onclick="deleteDados(${conferentes[index]['id_conferente']})"><i class="fa fa-trash"></i></button>
                        </td>
                      </tr>`;
        }
    }else {
        lista += `<tr>
                    <td colspan="3" class="text-center">Nenhum Registro Encontrado...</td>
                  </tr>`;
    }

    tableBodyConferentes.innerHTML = lista;
}

function saveDados() {
    
    let dados = {nome:document.getElementById('inputNomeConferente').value, id:document.getElementById('inputIdConferente').value};

    $.ajax({
        url : "./ajaxController/requisicoesAjax",
        type : 'POST',
        dataType: 'json',
        data : {tabela:'conferentes', metodo:'save', dados:dados},
        beforeSend: function(){
            $('#modalCadastrarConferente *').prop('disabled',true);
        },
        success : function(data){
            if(data['status']) {
                fecharModal();
                getAllDados();
                mensagemAlerta(1, data['mensagem']);
            }else {
                document.getElementById('bodyModalCadastro').innerHTML = ` <div class="form-group">
                                                                                <label for="inputNomeConferente">NOME DO CONFERENTE:</label>
                                                                                <input type="text" class="form-control" id="inputNomeConferente" required="true" name="inputNomeConferente" placeholder="Digite o nome do conferente..." style="border-color:#dd4b39;">
                                                                                <input type="hidden" id="inputIdConferente" name="inputIdConferente" value="${document.getElementById('inputIdConferente').value}">
                                                                                <small class="text-red">* ${data['mensagem']['nome_conferente']} </small>
                                                                           </div>`;
            }

            $('#modalCadastrarConferente *').prop('disabled',false);
        }
    });
}

function updateDados(value) {
    let conferentes = [];

    for(let conf of dadosConferente) {
        if(conf.id_conferente.indexOf(value) >= 0) {
            conferentes.push(conf);
        }
    }

    document.getElementById('headerModalCadastro').innerHTML = `<h4 class="modal-title">EDITAR CONFERENTE</h4>`;

    document.getElementById('bodyModalCadastro').innerHTML = ` <div class="form-group">
                                                                    <label for="inputNomeConferente">NOME DO CONFERENTE:</label>
                                                                    <input type="text" class="form-control" id="inputNomeConferente" required="true" name="inputNomeConferente" value="${conferentes[0]['nome_conferente']}" placeholder="Digite o nome do conferente...">
                                                                    <input type="hidden" id="inputIdConferente" name="inputIdConferente" value="${conferentes[0]['id_conferente']}">
                                                                </div>`;

    $('#modalCadastrarConferente').modal('show');
}

function deleteDados(value) {
    
    if(confirm('Deseja Excluir esse CONFERENTE?')) {
        let dados = {id:value};

        $.ajax({
            url : "./ajaxController/requisicoesAjax",
            type : 'POST',
            dataType: 'json',
            data : {tabela:'conferentes', metodo:'delete', dados:dados},
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
    $('#modalCadastrarConferente').modal('hide');

    document.getElementById('headerModalCadastro').innerHTML = `<h4 class="modal-title">CADASTRAR CONFERENTE</h4>`;

    document.getElementById('bodyModalCadastro').innerHTML = ` <div class="form-group">
                                                                    <label for="inputNomeConferente">NOME DO CONFERENTE:</label>
                                                                    <input type="text" class="form-control" id="inputNomeConferente" required="true" name="inputNomeConferente" placeholder="Digite o nome do conferente...">
                                                                    <input type="hidden" id="inputIdConferente" name="inputIdConferente" value="0">
                                                                </div>`;
}

getAllDados();












