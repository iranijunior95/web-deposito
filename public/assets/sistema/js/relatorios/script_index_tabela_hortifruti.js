let dadosProdutos = [];
let dadosTabela = [];

let btnAddProduto = document.getElementById('btnAddProduto');

document.getElementById('inputUndCx').addEventListener('change', function() {
    if(document.getElementById('inputUndCx').value === 'und') {

        document.getElementById('camposKgUnd').innerHTML = `<div class="form-group">
                                                                <label>UNIDADES:</label>
                                                                <input type="number" class="form-control" id="inputKG" name="inputKG">
                                                            </div>`;

    }else {

        document.getElementById('camposKgUnd').innerHTML = `<div class="form-group">
                                                                <label>KG:</label>
                                                                <input type="text" class="form-control" id="inputKG" name="inputKG">
                                                            </div>`;

        document.getElementById('inputKG').addEventListener('keyup', formatarPeso);
    }
});

document.getElementById('inputKG').addEventListener('keyup', formatarPeso);

document.getElementById('btnTabelaImprimir').addEventListener('click', imprimirTabela);

document.getElementById('btnTabelaCancelar').addEventListener('click', function() {
    document.getElementById('groupInputNomeMotorista').innerHTML = `<label for="inputNomeMotorista">MOTORISTA:</label>
                                                                    <input type="text" class="form-control" id="inputNomeMotorista" name="inputNomeMotorista" placeholder="Digite o nome do motorista...">`;

    document.getElementById('groupInputDataTabela').innerHTML = `<label for="inputDataTabela">DATA TABELA:</label>
                                                                 <input type="date" class="form-control" id="inputDataTabela" name="inputDataTabela">`;

    $('#modalImprimirTabela').modal('hide');                                                          
});

btnAddProduto.addEventListener('click', function() {
    let inputProdutos = document.getElementById('inputProdutos').value;
    let inputUndCx = document.getElementById('inputUndCx').value;
    let inputQtd = document.getElementById('inputQtd').value;
    let inputKG = document.getElementById('inputKG').value;

    if(inputQtd === '' || inputKG === '') {
        alert('Existem campos n??o preenchidos...');
    }else {
        let dados = {
            'id_produto' : inputProdutos,
            'produtos' : buscarDadosProdutoId(inputProdutos),
            'undCx' : inputUndCx,
            'qtd' : inputQtd,
            'kg' : inputKG
        };

        let result = dadosTabela.find( produto => produto.id_produto === dados.id_produto);
        
        if(!result) {
            dadosTabela.push(dados);

            renderizaDadosTabela();

            document.getElementById('inputQtd').value = '';
            document.getElementById('inputKG').value = '';
            document.getElementById('inputProdutos').focus();
        }else {
            alert('Produto j?? inserido na tabela...');
        }
    }

});

function buscarDadosProdutoId(id) {
    let produtos = [];

    for(let prod of dadosProdutos) {
        if(prod.id_produto.indexOf(id) >= 0) {
            produtos.push(prod);
        }
    }

    return produtos[0].nome_produto;
}

function renderizaDadosTabela() {

    if(dadosTabela == '') {
        document.getElementById('listaTabelaProdutos').innerHTML = `<tr>
                                                                        <td colspan="6" class="text-center">Tabela Vazia</td>
                                                                    </tr>`;
    }else {
        
        dadosTabela = dadosTabela.sort(compare);
        document.getElementById('listaTabelaProdutos').innerHTML = ``;
        let count = 1;
        let indice = 0;
        let medida = 'Kg';


        dadosTabela.find(Object =>{

            if(Object.undCx === 'und') {
                medida = 'UND';
            }else {
                medida = 'KG';
            }

            document.getElementById('listaTabelaProdutos').innerHTML += `<tr>
                                                                            <td class="text-center">${count++}</td>
                                                                            <td class="text-center">${Object.produtos}</td>
                                                                            <td class="text-center">${Object.qtd} cx</td>
                                                                            <td class="text-center">${Object.kg} ${medida}</td>
                                                                            <td class="text-center"></td>
                                                                            <td class="text-center">
                                                                                <button type="button" class="btn btn-default btn-xs" onclick="removerProduto(${indice++})"><i class="fa fa-remove"></i> REMOVER</button>
                                                                            </td>
                                                                        </tr>`;
        });

        document.getElementById('listaTabelaProdutos').innerHTML += `<tr>
                                                                        <td colspan="10" class="text-center">
                                                                            <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalImprimirTabela"><i class="fa fa-print"></i> IMPRIMIR TABELA</button>
                                                                        </td>
                                                                    </tr>`;
    }

    
}

function getAllDados() {

    $.ajax({
        url : "../ajaxController/requisicoesAjax",
        type : 'POST',
        dataType: 'json',
        data : {tabela:'produtos', metodo:'getAllProdutos'},
        success : function(data){ 
            dadosProdutos = data;
        }
    });
}

function removerProduto(indice) {
    
    dadosTabela.splice(indice, 1)
    renderizaDadosTabela()
}

function compare(a,b) {
    if (a.produtos < b.produtos)
       return -1;
    if (a.produtos > b.produtos)
      return 1;
    return 0;
}

function imprimirTabela() {
    if(exibirMensagenDeErro('motorista') & exibirMensagenDeErro('data')) {
        let dados = {motorista: document.getElementById('inputNomeMotorista').value, conferente: document.getElementById('inputNomeConferente').value, data: document.getElementById('inputDataTabela').value, tabela: dadosTabela}

        $.ajax({
            url : "../ajaxController/requisicoesAjax",
            type : 'POST',
            dataType: 'json',
            data : {tabela:'relatorios', metodo:'saveTabelahorti', dados:dados},
            beforeSend: function(){
                $('#modalImprimirTabela *').prop('disabled',true);
            },
            success : function(data){
                window.open('../relatorios/imprimir_tabela_hortifruti/'+data['id_hortifruti'], '_blank');
                $('#modalImprimirTabela *').prop('disabled',false);

                document.getElementById('groupInputNomeMotorista').innerHTML = `<label for="inputNomeMotorista">MOTORISTA:</label>
                                                                    <input type="text" class="form-control" id="inputNomeMotorista" name="inputNomeMotorista" placeholder="Digite o nome do motorista...">`;

                document.getElementById('groupInputDataTabela').innerHTML = `<label for="inputDataTabela">DATA TABELA:</label>
                                                                            <input type="date" class="form-control" id="inputDataTabela" name="inputDataTabela">`;

                $('#modalImprimirTabela').modal('hide');
            }

        });
    }else {
        console.log('n??o pode gerar...')
    }
}

function exibirMensagenDeErro(campo) {

    let inputNomeMotorista = document.getElementById('inputNomeMotorista').value;
    let inputDataTabela = document.getElementById('inputDataTabela').value;
    
    switch (campo) {
        case 'motorista':
            if(inputNomeMotorista === '') {
                document.getElementById('groupInputNomeMotorista').innerHTML = `<label for="inputNomeMotorista">MOTORISTA:</label>
                                                                                <input type="text" class="form-control" id="inputNomeMotorista" name="inputNomeMotorista" placeholder="Digite o nome do motorista..." style="border-color:#dd4b39;" value="${inputNomeMotorista}">
                                                                                <small class="text-red">* Digite o nome do motorista...</small>`;

                return false;
            }else {
                document.getElementById('groupInputNomeMotorista').innerHTML = `<label for="inputNomeMotorista">MOTORISTA:</label>
                                                                                <input type="text" class="form-control" id="inputNomeMotorista" name="inputNomeMotorista" placeholder="Digite o nome do motorista..." value="${inputNomeMotorista}">`;

                return true;
            }

            break;

        case 'data':
            if(inputDataTabela === '') {
                document.getElementById('groupInputDataTabela').innerHTML = `<label for="inputDataTabela">DATA TABELA:</label>
                                                                             <input type="date" class="form-control" id="inputDataTabela" name="inputDataTabela" style="border-color:#dd4b39;" value="${inputDataTabela}">
                                                                             <small class="text-red">* Digite a data...</small>`;

                return false;
            }else {
                document.getElementById('groupInputDataTabela').innerHTML = `<label for="inputDataTabela">DATA TABELA:</label>
                                                                             <input type="date" class="form-control" id="inputDataTabela" name="inputDataTabela" value="${inputDataTabela}">`;

                return true;
            }

            break;
    
        default:
            break;
    }
}

//Formata campo Peso
function formatarPeso() {
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
}

getAllDados();
renderizaDadosTabela();
