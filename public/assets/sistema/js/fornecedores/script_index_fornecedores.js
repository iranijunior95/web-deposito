let dadosFornecedor = [];

let btnCancelar = document.getElementById('btnCancelar');
let btnSalvar = document.getElementById('btnSalvar');
let tableBodyFornecedores = document.getElementById('tableBodyFornecedores');
let inputBuscarFornecedor = document.getElementById('inputBuscarFornecedor');

btnCancelar.addEventListener('click', fecharModal);
btnSalvar.addEventListener('click', saveDados);

inputBuscarFornecedor.addEventListener('keyup', searchDados);

function getAllDados() {

    $.ajax({
        url : "./ajaxController/requisicoesAjax",
        type : 'POST',
        dataType: 'json',
        data : {tabela:'fornecedores', metodo:'getAllFornecedores'},
        success : function(data){ 

            let lista = ``;
            let count = 1;

            dadosFornecedor = data;

            if(dadosFornecedor.length != 0) {
                for(let index = 0; index < dadosFornecedor.length; index++) {
                    lista += `<tr>
                                <td class="text-center">${count++}</td>
                                <td class="text-center text-bold text-blue">${dadosFornecedor[index]['nome_fornecedor']}</td>
                                <td class="text-center">${dadosFornecedor[index]['cnpj_cpf']}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-default btn-sm" onClick="updateDados(${dadosFornecedor[index]['id_fornecedor']})"><i class="fa fa-pencil"></i></button> 
                                    <button type="button" class="btn btn-default btn-sm" onclick="deleteDados(${dadosFornecedor[index]['id_fornecedor']})"><i class="fa fa-trash"></i></button>
                                </td>
                              </tr>`;
                }

            }else {
                lista += `<tr>
                            <td colspan="4" class="text-center">Nenhum Registro Encontrado...</td>
                          </tr>`;
            }

            tableBodyFornecedores.innerHTML = lista;
        }
    });
}

function searchDados() {
    let fornecedores = [];

    let lista = ``;
    let count = 1;

    for(let forn of dadosFornecedor) {
        if(forn.nome_fornecedor.toLocaleUpperCase().indexOf(inputBuscarFornecedor.value.toLocaleUpperCase()) >= 0) {
            fornecedores.push(forn);
        }
    }

    if(fornecedores.length != 0) {
        for(let index = 0; index < fornecedores.length; index++) {
            lista += `<tr>
                        <td class="text-center">${count++}</td>
                        <td class="text-center text-bold text-blue">${fornecedores[index]['nome_fornecedor']}</td>
                        <td class="text-center">${fornecedores[index]['cnpj_cpf']}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-default btn-sm" onClick="updateDados(${fornecedores[index]['id_fornecedor']})"><i class="fa fa-pencil"></i></button> 
                            <button type="button" class="btn btn-default btn-sm" onclick="deleteDados(${fornecedores[index]['id_fornecedor']})"><i class="fa fa-trash"></i></button>
                        </td>
                      </tr>`;
        }
    }else {
        lista += `<tr>
                    <td colspan="4" class="text-center">Nenhum Registro Encontrado...</td>
                  </tr>`;
    }

    tableBodyFornecedores.innerHTML = lista;
}

function saveDados() {
    let dados = {nome:document.getElementById('inputNomeFornecedor').value, cnpj_cpf:document.getElementById('inputCnpjCpf').value, id:document.getElementById('inputIdFornecedor').value};

    $.ajax({
        url : "./ajaxController/requisicoesAjax",
        type : 'POST',
        dataType: 'json',
        data : {tabela:'fornecedores', metodo:'save', dados:dados},
        beforeSend: function(){
            $('#modalCadastrarFornecedor *').prop('disabled',true);
        },
        success : function(data){
            if(data['status']) {
                fecharModal();
                getAllDados();
                mensagemAlerta(1, data['mensagem']);
            }else {

                if(data['mensagem']['nome_fornecedor'] && data['mensagem']['cnpj_cpf']) {
                    document.getElementById('bodyModalCadastro').innerHTML = ` <div class="form-group">
                                                                                    <label for="inputNomeFornecedor">NOME DO FORNECEDOR:</label>
                                                                                    <input type="text" class="form-control" id="inputNomeFornecedor" required="true" name="inputNomeFornecedor" value="${document.getElementById('inputNomeFornecedor').value}" placeholder="Digite o nome do fornecedor..." style="border-color:#dd4b39;">
                                                                                    <small class="text-red">* ${data['mensagem']['nome_fornecedor']} </small>
                                                                                </div>
                                                                           
                                                                                <div class="form-group">
                                                                                    <label for="inputCnpjCpf">CNPJ/CPF:</label>
                                                                                    <input type="text" class="form-control" id="inputCnpjCpf" required="true" name="inputCnpjCpf" onkeypress='mascaraMutuario(this,cpfCnpj)' onblur='clearTimeout()' maxlength="18" value="${document.getElementById('inputCnpjCpf').value}" placeholder="Digite o CNPJ ou CPF do fornecedor..." style="border-color:#dd4b39;">
                                                                                    <small class="text-red">* ${data['mensagem']['cnpj_cpf']} </small>
                                                                                </div>
                                                                           
                                                                                <input type="hidden" id="inputIdFornecedor" name="inputIdFornecedor" value="${document.getElementById('inputIdFornecedor').value}">`;

                }else if(!data['mensagem']['nome_fornecedor'] && data['mensagem']['cnpj_cpf']) {
                    document.getElementById('bodyModalCadastro').innerHTML = ` <div class="form-group">
                                                                                    <label for="inputNomeFornecedor">NOME DO FORNECEDOR:</label>
                                                                                    <input type="text" class="form-control" id="inputNomeFornecedor" required="true" name="inputNomeFornecedor" value="${document.getElementById('inputNomeFornecedor').value}" placeholder="Digite o nome do fornecedor...">
                                                                                </div>
                                                                           
                                                                                <div class="form-group">
                                                                                    <label for="inputCnpjCpf">CNPJ/CPF:</label>
                                                                                    <input type="text" class="form-control" id="inputCnpjCpf" required="true" name="inputCnpjCpf" onkeypress='mascaraMutuario(this,cpfCnpj)' onblur='clearTimeout()' maxlength="18" value="${document.getElementById('inputCnpjCpf').value}" placeholder="Digite o CNPJ ou CPF do fornecedor..." style="border-color:#dd4b39;">
                                                                                    <small class="text-red">* ${data['mensagem']['cnpj_cpf']} </small>
                                                                                </div>
                                                                           
                                                                                <input type="hidden" id="inputIdFornecedor" name="inputIdFornecedor" value="${document.getElementById('inputIdFornecedor').value}">`;
                }else {
                    document.getElementById('bodyModalCadastro').innerHTML = ` <div class="form-group">
                                                                                    <label for="inputNomeFornecedor">NOME DO FORNECEDOR:</label>
                                                                                    <input type="text" class="form-control" id="inputNomeFornecedor" required="true" name="inputNomeFornecedor" value="${document.getElementById('inputNomeFornecedor').value}" placeholder="Digite o nome do fornecedor..." style="border-color:#dd4b39;">
                                                                                    <small class="text-red">* ${data['mensagem']['nome_fornecedor']} </small>
                                                                                </div>
                                                                           
                                                                                <div class="form-group">
                                                                                    <label for="inputCnpjCpf">CNPJ/CPF:</label>
                                                                                    <input type="text" class="form-control" id="inputCnpjCpf" required="true" name="inputCnpjCpf" onkeypress='mascaraMutuario(this,cpfCnpj)' onblur='clearTimeout()' maxlength="18" value="${document.getElementById('inputCnpjCpf').value}" placeholder="Digite o CNPJ ou CPF do fornecedor...">
                                                                                </div>
                                                                           
                                                                                <input type="hidden" id="inputIdFornecedor" name="inputIdFornecedor" value="${document.getElementById('inputIdFornecedor').value}">`;
                }
                
            }

            $('#modalCadastrarFornecedor *').prop('disabled',false);
        }
    });
}

function updateDados(value) {
    let fornecedores = [];

    for(let forn of dadosFornecedor) {
        if(forn.id_fornecedor.indexOf(value) >= 0) {
            fornecedores.push(forn);
        }
    }

    document.getElementById('headerModalCadastro').innerHTML = `<h4 class="modal-title">EDITAR FORNECEDOR</h4>`;

    document.getElementById('bodyModalCadastro').innerHTML = ` <div class="form-group">
                                                                    <label for="inputNomeFornecedor">NOME DO FORNECEDOR:</label>
                                                                    <input type="text" class="form-control" id="inputNomeFornecedor" required="true" name="inputNomeFornecedor" value="${fornecedores[0]['nome_fornecedor']}" placeholder="Digite o nome do fornecedor...">
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label for="inputCnpjCpf">CNPJ/CPF:</label>
                                                                    <input type="text" class="form-control" id="inputCnpjCpf" required="true" name="inputCnpjCpf" onkeypress='mascaraMutuario(this,cpfCnpj)' onblur='clearTimeout()' maxlength="18" value="${fornecedores[0]['cnpj_cpf']}" placeholder="Digite o CNPJ ou CPF do fornecedor...">
                                                                </div>
                                                                
                                                                <input type="hidden" id="inputIdFornecedor" name="inputIdFornecedor" value="${fornecedores[0]['id_fornecedor']}">`;

    $('#modalCadastrarFornecedor').modal('show');
}

function deleteDados(value) {
    
    if(confirm('Deseja Excluir esse FORNECEDOR?')) {
        let dados = {id:value};

        $.ajax({
            url : "./ajaxController/requisicoesAjax",
            type : 'POST',
            dataType: 'json',
            data : {tabela:'fornecedores', metodo:'delete', dados:dados},
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
    $('#modalCadastrarFornecedor').modal('hide');

    document.getElementById('headerModalCadastro').innerHTML = `<h4 class="modal-title">CADASTRAR FORNECEDOR</h4>`;

    document.getElementById('bodyModalCadastro').innerHTML = ` <div class="form-group">
                                                                    <label for="inputNomeFornecedor">NOME DO FORNECEDOR:</label>
                                                                    <input type="text" class="form-control" id="inputNomeFornecedor" required="true" name="inputNomeFornecedor" placeholder="Digite o nome do fornecedor...">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="inputCnpjCpf">CNPJ/CPF:</label>
                                                                    <input type="text" class="form-control" id="inputCnpjCpf" required="true" name="inputCnpjCpf" onkeypress='mascaraMutuario(this,cpfCnpj)' onblur='clearTimeout()' maxlength="18" placeholder="Digite o CNPJ ou CPF do fornecedor...">
                                                                </div>
                                                                
                                                                <input type="hidden" id="inputIdFornecedor" name="inputIdFornecedor" value="0">`;
}

//==================== Formatar CNPJ E CPF ====================//
function mascaraMutuario(o,f){
    v_obj=o
    v_fun=f
    setTimeout('execmascara()',1)
}
 
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}

function cpfCnpj(v){
 
    //Remove tudo o que nÃ£o Ã© dÃ­gito
    v=v.replace(/\D/g,"")
 
    if (v.length <= 13) { //CPF
 
        //Coloca um ponto entre o terceiro e o quarto dÃ­gitos
        v=v.replace(/(\d{3})(\d)/,"$1.$2")
 
        //Coloca um ponto entre o terceiro e o quarto dÃ­gitos
        //de novo (para o segundo bloco de nÃºmeros)
        v=v.replace(/(\d{3})(\d)/,"$1.$2")
 
        //Coloca um hÃ­fen entre o terceiro e o quarto dÃ­gitos
        v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
 
    } else { //CNPJ
 
        //Coloca ponto entre o segundo e o terceiro dÃ­gitos
        v=v.replace(/^(\d{2})(\d)/,"$1.$2")
 
        //Coloca ponto entre o quinto e o sexto dÃ­gitos
        v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")
 
        //Coloca uma barra entre o oitavo e o nono dÃ­gitos
        v=v.replace(/\.(\d{3})(\d)/,".$1/$2")
 
        //Coloca um hÃ­fen depois do bloco de quatro dÃ­gitos
        v=v.replace(/(\d{4})(\d)/,"$1-$2")
 
    }
 
    return v
 
}

getAllDados();