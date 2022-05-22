function getAllDadosConferentes() {

    $.ajax({
        url : "./ajaxController/requisicoesAjax",
        type : 'POST',
        dataType: 'json',
        data : {tabela:'conferentes', metodo:'getAllConferentes'},
        success : function(data){ 
            let count = 0;

            function contador() {
                if(count < data.length) {
                    count++;
                    document.getElementById('countConferentes').innerHTML = count;
                }else {
                    clearInterval(interval);
                }
            }

            let interval = setInterval(contador, 100);
            
        }
    });
}

function getAllDadosFornecedores() {

    $.ajax({
        url : "./ajaxController/requisicoesAjax",
        type : 'POST',
        dataType: 'json',
        data : {tabela:'fornecedores', metodo:'getAllFornecedores'},
        success : function(data){ 
            let count = 0;

            function contador() {
                if(count < data.length) {
                    count++;
                    document.getElementById('countFornecedores').innerHTML = count;
                }else {
                    clearInterval(interval);
                }
            }

            let interval = setInterval(contador, 10);
            
        }
    });
}

function getAllDadosSetores() {

    $.ajax({
        url : "./ajaxController/requisicoesAjax",
        type : 'POST',
        dataType: 'json',
        data : {tabela:'setores', metodo:'getAllSetores'},
        success : function(data){ 
            let count = 0;

            function contador() {
                if(count < data.length) {
                    count++;
                    document.getElementById('countSetores').innerHTML = count;
                }else {
                    clearInterval(interval);
                }
            }

            let interval = setInterval(contador, 100);
            
        }
    });
}

getAllDadosConferentes();
getAllDadosFornecedores();
getAllDadosSetores();












