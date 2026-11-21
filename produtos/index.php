<?php
require_once __DIR__.'/../config/conexao.php'; $titulo='Produtos'; $mensagem='';
if(isset($_GET['excluir'])) {
    try {
        $s=$pdo->prepare("DELETE FROM produtos WHERE id=?"); $s->execute([(int)$_GET['excluir']]);
        header('Location: index.php?msg=excluido'); exit;
    } catch(PDOException $e) {
        $mensagem='Este produto não pode ser excluído porque está vinculado a um ou mais fretes.';
    }
}
if(isset($_GET['msg']) && $_GET['msg']==='excluido') $mensagem='Registro excluído com sucesso.';
$itens=$pdo->query("SELECT p.*, (SELECT COUNT(*) FROM frete_produtos fp WHERE fp.produto_id=p.id) AS usos FROM produtos p ORDER BY p.nome")->fetchAll();
include __DIR__.'/../includes/topo.php'; ?>
<div class="d-flex justify-content-between mb-3"><h1 class="h2 page-title">Produtos</h1><a class="btn btn-primary" href="cadastrar.php">Cadastrar produto</a></div>
<?php if($mensagem): ?><div class="alert alert-info"><?=htmlspecialchars($mensagem)?></div><?php endif; ?>
<div class="card p-3"><div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Nome</th><th>Descrição</th><th>Peso (kg)</th><th>Fretes vinculados</th><th>Ações</th></tr></thead><tbody>
<?php foreach($itens as $i): ?><tr><td><?=htmlspecialchars($i['nome'])?></td><td><?=htmlspecialchars($i['descricao']??'')?></td><td><?=number_format($i['peso'],2,',','.')?></td><td><?=$i['usos']?></td><td><a class="btn btn-sm btn-outline-primary" href="cadastrar.php?id=<?=$i['id']?>">Editar</a> <a data-confirm class="btn btn-sm btn-outline-danger" href="?excluir=<?=$i['id']?>">Excluir</a></td></tr><?php endforeach; ?>
<?php if(!$itens): ?><tr><td colspan="5" class="text-center text-muted">Nenhum produto cadastrado.</td></tr><?php endif; ?>
</tbody></table></div></div><?php include __DIR__.'/../includes/rodape.php'; ?>
