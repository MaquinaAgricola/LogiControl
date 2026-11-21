<?php
require_once __DIR__.'/../config/conexao.php';$id=(int)($_GET['id']??0);$erro='';$item=['identificacao'=>'','logradouro'=>'','numero'=>'','bairro'=>'','cidade'=>'','estado'=>'','cep'=>''];
if($id){$s=$pdo->prepare("SELECT * FROM enderecos WHERE id=?");$s->execute([$id]);$item=$s->fetch()?:$item;}
if($_SERVER['REQUEST_METHOD']==='POST'){$campos=['identificacao','logradouro','numero','bairro','cidade','estado','cep'];$d=[];foreach($campos as $c)$d[$c]=trim($_POST[$c]??'');
if($d['identificacao']===''||$d['cidade']===''||strlen($d['estado'])!==2)$erro='Preencha identificação, cidade e UF com duas letras.';
else{if($id){$sql="UPDATE enderecos SET identificacao=?,logradouro=?,numero=?,bairro=?,cidade=?,estado=?,cep=? WHERE id=?";$pdo->prepare($sql)->execute([...array_values($d),$id]);}else{$sql="INSERT INTO enderecos(identificacao,logradouro,numero,bairro,cidade,estado,cep) VALUES(?,?,?,?,?,?,?)";$pdo->prepare($sql)->execute(array_values($d));}header('Location:index.php');exit;}$item=$d;}
$titulo=$id?'Editar endereço':'Cadastrar endereço';include __DIR__.'/../includes/topo.php';?>
<h1 class="h2 page-title mb-3"><?=$titulo?></h1><?php if($erro):?><div class="alert alert-danger"><?=htmlspecialchars($erro)?></div><?php endif;?>
<div class="card p-4"><form method="post"><div class="row g-3">
<?php foreach(['identificacao'=>'Identificação (ex.: Origem Fazenda)','logradouro'=>'Logradouro','numero'=>'Número','bairro'=>'Bairro','cidade'=>'Cidade','estado'=>'UF','cep'=>'CEP'] as $c=>$rotulo):?><div class="col-md-6"><label class="form-label"><?=$rotulo?></label><input class="form-control" name="<?=$c?>" value="<?=htmlspecialchars($item[$c]??'')?>"></div><?php endforeach;?>
</div><div class="mt-3"><button class="btn btn-primary">Salvar</button> <a class="btn btn-outline-secondary" href="index.php">Voltar</a></div></form></div><?php include __DIR__.'/../includes/rodape.php';?>
