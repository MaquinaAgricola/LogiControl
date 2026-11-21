<?php
require_once __DIR__.'/../config/conexao.php';
$data=$_GET['data']??'';
if(!preg_match('/^\d{4}-\d{2}-\d{2}$/',$data)){http_response_code(400);exit('Data inválida.');}
$s=$pdo->prepare("SELECT f.id,f.data_frete,t.nome transportador,eo.identificacao origem,eo.cidade cidade_origem,ed.identificacao destino,ed.cidade cidade_destino,COUNT(fp.produto_id) quantidade_produtos,GROUP_CONCAT(p.nome SEPARATOR ' | ') produtos,COALESCE(SUM(p.peso),0) peso_total FROM fretes f JOIN transportadores t ON t.id=f.transportador_id JOIN enderecos eo ON eo.id=f.origem_id JOIN enderecos ed ON ed.id=f.destino_id JOIN frete_produtos fp ON fp.frete_id=f.id JOIN produtos p ON p.id=fp.produto_id WHERE f.data_frete=? GROUP BY f.id ORDER BY f.id");
$s->execute([$data]);$linhas=$s->fetchAll();
header('Content-Type: text/csv; charset=utf-8');header('Content-Disposition: attachment; filename="relatorio_fretes_'.$data.'.csv"');
$out=fopen('php://output','w');fwrite($out,"\xEF\xBB\xBF");
fputcsv($out,['Número','Data','Transportador','Origem','Cidade origem','Destino','Cidade destino','Quantidade de produtos','Produtos','Peso total (kg)'],';');
foreach($linhas as $l)fputcsv($out,[$l['id'],$l['data_frete'],$l['transportador'],$l['origem'],$l['cidade_origem'],$l['destino'],$l['cidade_destino'],$l['quantidade_produtos'],$l['produtos'],number_format((float)$l['peso_total'],2,'.','')],';');
fclose($out);
