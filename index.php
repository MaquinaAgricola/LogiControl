<?php
require_once __DIR__ . '/config/conexao.php';
$titulo = 'Painel principal';
$totais = [];
foreach (['produtos'=>'Produtos','enderecos'=>'Endereços','transportadores'=>'Transportadores','fretes'=>'Fretes'] as $tabela=>$rotulo) {
    $totais[$rotulo] = (int)$pdo->query("SELECT COUNT(*) FROM $tabela")->fetchColumn();
}
$recentes = $pdo->query("SELECT f.id, f.data_frete, t.nome AS transportador, eo.cidade AS origem, ed.cidade AS destino
 FROM fretes f JOIN transportadores t ON t.id=f.transportador_id
 JOIN enderecos eo ON eo.id=f.origem_id JOIN enderecos ed ON ed.id=f.destino_id
 ORDER BY f.id DESC LIMIT 5")->fetchAll();
include __DIR__ . '/includes/topo.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4"><div><h1 class="page-title h2">Painel principal</h1><p class="text-muted mb-0">Visão geral da operação logística.</p></div><a class="btn btn-primary" href="fretes/cadastrar.php">+ Novo frete</a></div>
<div class="row g-3 mb-4">
<?php foreach($totais as $nome=>$valor): ?>
<div class="col-6 col-lg-3"><div class="card card-stat p-3"><div class="text-muted"><?= htmlspecialchars($nome) ?></div><div class="display-6 fw-bold"><?= $valor ?></div></div></div>
<?php endforeach; ?>
</div>
<div class="card p-3"><h2 class="h5 mb-3">Fretes recentes</h2>
<div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Nº</th><th>Data</th><th>Transportador</th><th>Origem</th><th>Destino</th></tr></thead><tbody>
<?php if(!$recentes): ?><tr><td colspan="5" class="text-center text-muted">Nenhum frete cadastrado.</td></tr><?php endif; ?>
<?php foreach($recentes as $r): ?><tr><td>#<?= $r['id'] ?></td><td><?= date('d/m/Y',strtotime($r['data_frete'])) ?></td><td><?= htmlspecialchars($r['transportador']) ?></td><td><?= htmlspecialchars($r['origem']) ?></td><td><?= htmlspecialchars($r['destino']) ?></td></tr><?php endforeach; ?>
</tbody></table></div></div>
<?php include __DIR__ . '/includes/rodape.php'; ?>
