let mensagem = document.getElementById('mensagem');

if(mensagem.value != 0) {
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: mensagem.value,
        showConfirmButton: false,
    });
}

function deleteDados(value) {
    
    if(confirm('Deseja Excluir esse LANÇAMENTO?')) {
        let dados = {id:value};

        $.ajax({
            url : "../../ajaxController/requisicoesAjax",
            type : 'POST',
            dataType: 'json',
            data : {tabela:'lancamentos', metodo:'delete', dados:dados},
            success : function(data){
                if(data) {
                    window.location.href = `../../lancamentos`;
                }else {
                    window.location.href = `../../lancamentos/detalhes/${value}`;
                }
            }
        });
    }
    
}
