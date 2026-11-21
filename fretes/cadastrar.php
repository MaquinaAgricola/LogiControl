<?php
require_once __DIR__.'/../config/conexao.php';$titulo='Gerar frete';$erro='';
$produtos=$pdo->query("SELECT id,nome,peso FROM produtos ORDER BY nome")->fetchAll();
$enderecos=$pdo->query("SELECT id,identificacao,cidade,estado FROM enderecos ORDER BY cidade")->fetchAll();
$transportadores=$pdo->query("SELECT id,nome FROM transportadores ORDER BY nome")->fetchAll();
if($_SERVER['REQUEST_METHOD']==='POST'){
 $transportador=(int)($_POST['transportador_id']??0);$origem=(int)($_POST['origem_id']??0);$destino=(int)($_POST['destino_id']??0);$data=$_POST['data_frete']??date('Y-m-d');$ids=array_filter(array_map('intval',$_POST['produtos']??[]));
 if(!$transportador||!$origem||!$destino||$origem===$destino||!$ids)$erro='Selecione transportador, origem, destino diferentes e pelo menos um produto.';
 else{try{$pdo->beginTransaction();$s=$pdo->prepare("INSERT INTO fretes(transportador_id,origem_id,destino_id,data_frete) VALUES(?,?,?,?)");$s->execute([$transportador,$origem,$destino,$data]);$freteId=(int)$pdo->lastInsertId();$p=$pdo->prepare("INSERT INTO frete_produtos(frete_id,produto_id) VALUES(?,?)");foreach(array_unique($ids) as $produtoId)$p->execute([$freteId,$produtoId]);$pdo->commit();header('Location:index.php');exit;}catch(Throwable $e){$pdo->rollBack();$erro='Não foi possível salvar o frete: '.$e->getMessage();}}
}
include __DIR__.'/../includes/topo.php';?>
<h1 class="h2 page-title mb-3">Gerar frete</h1><?php if($erro):?><div class="alert alert-danger"><?=htmlspecialchars($erro)?></div><?php endif;?>
<?php if(!$produtos||!$enderecos||!$transportadores):?><div class="alert alert-warning">Antes de gerar um frete, cadastre pelo menos um produto, dois endereços e um transportador.</div><?php endif;?>
<div class="card p-4"><form method="post">
<div class="row g-3"><div class="col-md-6"><label class="form-label">Transportador</label><select required name="transportador_id" class="form-select"><option value="">Selecione</option><?php foreach($transportadores as $t):?><option value="<?=$t['id']?>"><?=htmlspecialchars($t['nome'])?></option><?php endforeach;?></select></div>
<div class="col-md-6"><label class="form-label">Data do frete</label><input required type="date" name="data_frete" class="form-control" value="<?=date('Y-m-d')?>"></div>
<div class="col-md-6"><label class="form-label">Endereço de origem</label><select required name="origem_id" class="form-select"><option value="">Selecione</option><?php foreach($enderecos as $e):?><option value="<?=$e['id']?>"><?=htmlspecialchars($e['identificacao'].' - '.$e['cidade'].'/'.$e['estado'])?></option><?php endforeach;?></select></div>
<div class="col-md-6"><label class="form-label">Endereço de destino</label><select required name="destino_id" class="form-select"><option value="">Selecione</option><?php foreach($enderecos as $e):?><option value="<?=$e['id']?>"><?=htmlspecialchars($e['identificacao'].' - '.$e['cidade'].'/'.$e['estado'])?></option><?php endforeach;?></select></div></div>
<hr><div class="d-flex justify-content-between align-items-center mb-2"><h2 class="h5">Produtos transportados</h2><button type="button" id="adicionar-produto" class="btn btn-sm btn-outline-primary">+ Adicionar produto</button></div>
<div id="lista-produtos"><div class="row g-2 linha-produto mb-2"><div class="col-10"><select required name="produtos[]" class="form-select"><option value="">Selecione um produto</option><?php foreach($produtos as $p):?><option value="<?=$p['id']?>"><?=htmlspecialchars($p['nome'].' — '.$p['peso'].' kg')?></option><?php endforeach;?></select></div><div class="col-2"><button type="button" class="btn btn-outline-danger remover-produto">Remover</button></div></div></div>
<button class="btn btn-primary mt-3" <?=(!$produtos||!$enderecos||!$transportadores)?'disabled':''?>>Salvar frete</button> <a class="btn btn-outline-secondary mt-3" href="index.php">Voltar</a></form></div><?php include __DIR__.'/../includes/rodape.php';?>
