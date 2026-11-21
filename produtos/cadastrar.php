<?php
require_once __DIR__.'/../config/conexao.php'; $id=(int)($_GET['id']??0); $erro='';
$item=['nome'=>'','descricao'=>'','peso'=>''];
if($id){$s=$pdo->prepare("SELECT * FROM produtos WHERE id=?");$s->execute([$id]);$item=$s->fetch() ?: $item;}
if($_SERVER['REQUEST_METHOD']==='POST'){
 $dados=[trim($_POST['nome']??''),trim($_POST['descricao']??''),(float)($_POST['peso']??0)];
 if($dados[0]==='' || $dados[2]<=0){$erro='Informe o nome e um peso maior que zero.';}
 else {if($id){$s=$pdo->prepare("UPDATE produtos SET nome=?,descricao=?,peso=? WHERE id=?");$s->execute([...$dados,$id]);}
 else{$s=$pdo->prepare("INSERT INTO produtos(nome,descricao,peso) VALUES(?,?,?)");$s->execute($dados);}
 header('Location: index.php');exit;}
 $item=['nome'=>$dados[0],'descricao'=>$dados[1],'peso'=>$dados[2]];
}
$titulo=$id?'Editar produto':'Cadastrar produto';include __DIR__.'/../includes/topo.php'; ?>
<h1 class="h2 page-title mb-3"><?= $titulo ?></h1><?php if($erro): ?><div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div><?php endif; ?>
<div class="card p-4"><form method="post"><div class="mb-3"><label class="form-label">Nome do produto</label><input required class="form-control" name="nome" value="<?= htmlspecialchars($item['nome']) ?>"></div>
<div class="mb-3"><label class="form-label">Descrição</label><textarea class="form-control" name="descricao"><?= htmlspecialchars($item['descricao']??'') ?></textarea></div>
<div class="mb-3"><label class="form-label">Peso (kg)</label><input required min="0.01" step="0.01" type="number" class="form-control" name="peso" value="<?= htmlspecialchars((string)$item['peso']) ?>"></div>
<button class="btn btn-primary">Salvar</button> <a class="btn btn-outline-secondary" href="index.php">Voltar</a></form></div>
<?php include __DIR__.'/../includes/rodape.php'; ?>
