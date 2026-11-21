<?php
require_once __DIR__.'/../config/conexao.php';$titulo='Endereços';$mensagem='';
if(isset($_GET['excluir'])){try{$s=$pdo->prepare("DELETE FROM enderecos WHERE id=?");$s->execute([(int)$_GET['excluir']]);header('Location:index.php?msg=excluido');exit;}catch(PDOException $e){$mensagem='Este endereço não pode ser excluído porque está sendo utilizado como origem ou destino de um frete.';}}
if(($_GET['msg']??'')==='excluido')$mensagem='Registro excluído com sucesso.';
$itens=$pdo->query("SELECT e.*,((SELECT COUNT(*) FROM fretes f WHERE f.origem_id=e.id)+(SELECT COUNT(*) FROM fretes f WHERE f.destino_id=e.id)) AS usos FROM enderecos e ORDER BY cidade,estado")->fetchAll();include __DIR__.'/../includes/topo.php';?>
<div class="d-flex justify-content-between mb-3"><h1 class="h2 page-title">Endereços</h1><a class="btn btn-primary" href="cadastrar.php">Cadastrar endereço</a></div>
<?php if($mensagem):?><div class="alert alert-info"><?=htmlspecialchars($mensagem)?></div><?php endif;?>
<div class="card p-3"><div class="table-responsive"><table class="table"><thead><tr><th>Identificação</th><th>Logradouro</th><th>Cidade/UF</th><th>Fretes vinculados</th><th>Ações</th></tr></thead><tbody>
<?php foreach($itens as $i):?><tr><td><?=htmlspecialchars($i['identificacao'])?></td><td><?=htmlspecialchars($i['logradouro']??'')?></td><td><?=htmlspecialchars($i['cidade'].'/'.$i['estado'])?></td><td><?=$i['usos']?></td><td><a class="btn btn-sm btn-outline-primary" href="cadastrar.php?id=<?=$i['id']?>">Editar</a> <a data-confirm class="btn btn-sm btn-outline-danger" href="?excluir=<?=$i['id']?>">Excluir</a></td></tr><?php endforeach;?>
<?php if(!$itens):?><tr><td colspan="5" class="text-center text-muted">Nenhum endereço cadastrado.</td></tr><?php endif;?></tbody></table></div></div><?php include __DIR__.'/../includes/rodape.php';?>
