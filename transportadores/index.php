<?php
require_once __DIR__.'/../config/conexao.php';$titulo='Transportadores';$mensagem='';
if(isset($_GET['excluir'])){try{$s=$pdo->prepare("DELETE FROM transportadores WHERE id=?");$s->execute([(int)$_GET['excluir']]);header('Location:index.php?msg=excluido');exit;}catch(PDOException $e){$mensagem='Este transportador não pode ser excluído porque possui fretes vinculados.';}}
if(($_GET['msg']??'')==='excluido')$mensagem='Registro excluído com sucesso.';
$itens=$pdo->query("SELECT t.*,(SELECT COUNT(*) FROM fretes f WHERE f.transportador_id=t.id) AS usos FROM transportadores t ORDER BY t.nome")->fetchAll();include __DIR__.'/../includes/topo.php';?>
<div class="d-flex justify-content-between mb-3"><h1 class="h2 page-title">Transportadores</h1><a class="btn btn-primary" href="cadastrar.php">Cadastrar transportador</a></div>
<?php if($mensagem):?><div class="alert alert-info"><?=htmlspecialchars($mensagem)?></div><?php endif;?>
<div class="card p-3"><div class="table-responsive"><table class="table"><thead><tr><th>Nome</th><th>Documento</th><th>Telefone</th><th>Fretes vinculados</th><th>Ações</th></tr></thead><tbody>
<?php foreach($itens as $i):?><tr><td><?=htmlspecialchars($i['nome'])?></td><td><?=htmlspecialchars($i['documento']??'')?></td><td><?=htmlspecialchars($i['telefone']??'')?></td><td><?=$i['usos']?></td><td><a class="btn btn-sm btn-outline-primary" href="cadastrar.php?id=<?=$i['id']?>">Editar</a> <a data-confirm class="btn btn-sm btn-outline-danger" href="?excluir=<?=$i['id']?>">Excluir</a></td></tr><?php endforeach;?>
<?php if(!$itens):?><tr><td colspan="5" class="text-center text-muted">Nenhum transportador cadastrado.</td></tr><?php endif;?></tbody></table></div></div><?php include __DIR__.'/../includes/rodape.php';?>
