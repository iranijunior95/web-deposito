<div class="container">
    <br>
    <div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-body text-center" style="background-color: #008d4c; color:#FFFFFF">
					<h1><i class="fa fa-file-text"></i></h1>
					<h2><?=$lancamento['nome_fornecedor']?></h2>
				</div>
				<div class="box-footer text-center">
					<a href="<?=base_url('lancamentos/form_edit/'.$lancamento['id_lancamento'])?>" class="btn btn-default btn-sm"><i class="fa fa-pencil"></i> <strong>EDITAR</strong></a>
					<button class="btn btn-default btn-sm" id="btnExcluir" onclick="deleteDados('<?=$lancamento['id_lancamento']?>')"><i class="fa fa-trash"></i> <strong>EXCLUIR</strong></button>
					<a href="<?=base_url('lancamentos')?>" class="btn btn-default btn-sm"><i class="fa fa-reply-all"></i> <strong>VOLTAR</strong></a>
				</div>
			</div>
		</div>
    </div>

    <div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-body table-responsive no-padding">
					<table class="table table-striped">
						<tbody>
							<tr>
								<td><strong>Nº LANÇAMENTO:</strong></td>
								<td class="text-bold">#<?=$lancamento['id_lancamento']?></td>
							</tr>
							<tr>
								<td><strong>FORNECEDOR:</strong></td>
								<td class="text-primary text-bold"><?=$lancamento['nome_fornecedor']?></td>
							</tr>
							<tr>
								<td><strong>CONFERENTE:</strong></td>
								<td class="text-bold"><?=$lancamento['nome_conferente']?></td>
							</tr>
							<tr>
								<td><strong>SETOR:</strong></td>
								<td class="text-bold"><?=$lancamento['nome_setor']?></td>
							</tr>

							<tr>
								<td colspan="2"><p class="page-header"></p></td>
							</tr>

							<tr>
								<td><strong>Nº DA NOTA:</strong></td>
								<td><?=$lancamento['numero_nota']?></td>
							</tr>
							<tr>
								<td><strong>VALOR DA NOTA:</strong></td>
								<td>R$ <?=$lancamento['valor_nota']?></td>
							</tr>
							<tr>
								<td><strong>PESO DA NOTA:</strong></td>
								<td><?=$lancamento['peso_nota']?> Kg</td>
							</tr>

							<tr>
								<td colspan="2"><p class="page-header"></p></td>
							</tr>

							<tr>
								<td><strong>NOME DO MOTORISTA:</strong></td>
								<td><?=$lancamento['nome_motorista']?></td>
							</tr>
							<tr>
								<td><strong>PLACA DO VEÍCULO:</strong></td>
								<td><?=$lancamento['placa_veiculo']?></td>
							</tr>

							<tr>
								<td colspan="2"><p class="page-header"></p></td>
							</tr>

							<tr>
								<td><strong>TAXA DE DESCARREGO:</strong></td>
								<td>R$ <?=$lancamento['taxa_descarrego']?></td>
							</tr>
							<tr>
								<td><strong>HORA DE ENTRADA:</strong></td>
								<td><?=$lancamento['hora_entrada']?> Hs</td>
							</tr>
							<tr>
								<td><strong>HORA DE SAÍDA:</strong></td>
								<td><?=$lancamento['hora_saida']?> Hs</td>
							</tr>
							<tr>
								<td><strong>DATA DE ENTRADA:</strong></td>
								<td><?=date('d/m/Y',  strtotime($lancamento['data_entrada']))?></td>
							</tr>
						</tbody>
					</table>	
				</div>
			</div>
		</div>
    </div>

	
</div>

<?php
session_start();

if(!isset($_SESSION['retorno'])) {
	echo '<input type="hidden" name="mensagem" id="mensagem" value="0">';
}else {

	$mensagem = $_SESSION['retorno'];
	unset($_SESSION['retorno']);

	echo '<input type="hidden" name="mensagem" id="mensagem" value="'.$mensagem.'">';
}

?>