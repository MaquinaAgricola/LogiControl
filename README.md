# LogiControl — Gerenciador Logístico

Projeto acadêmico para Fundamentos de Programação para Internet.

## Funcionalidades
- Cadastro, edição, listagem e exclusão de produtos, endereços e transportadores.
- Geração de fretes com um transportador, origem, destino e vários produtos.
- Detalhamento de frete com lista de produtos e peso total.
- Dashboard com indicadores e fretes recentes.
- Relatório diário CSV com quantidade de produtos e peso total.
- Mensagens amigáveis quando um registro não pode ser excluído por estar vinculado a fretes.

## Tecnologias
PHP 8+, MySQL/MariaDB, HTML5, CSS3, JavaScript e Bootstrap 5.

## Instalação no XAMPP
1. Extraia a pasta `logocontrol` em `C:\\xampp\\htdocs\\`.
2. Inicie Apache e MySQL no XAMPP.
3. Acesse `http://localhost/phpmyadmin`.
4. Importe `banco.sql`.
5. Confira as credenciais em `config/conexao.php` (padrão: usuário `root`, senha vazia).
6. Abra `http://localhost/logocontrol/`.

## Modelo de dados
- `produtos`: itens transportados.
- `enderecos`: locais de origem e destino.
- `transportadores`: responsáveis pelo transporte.
- `fretes`: cabeçalho do frete.
- `frete_produtos`: tabela associativa que relaciona vários produtos a um frete.

## Testes recomendados
1. Cadastre pelo menos dois produtos, dois endereços e um transportador.
2. Gere um frete com dois ou mais produtos.
3. Abra Fretes > Ver e confira os produtos e o peso total.
4. Tente excluir um produto já usado em frete: o sistema deve informar por que não é possível.
5. Gere o relatório CSV para a data do frete e confira quantidade de produtos e peso total.

## Observação
Versão acadêmica para execução local. Antes da publicação em servidor real, implemente autenticação, proteção CSRF, controle de permissões e revisão de segurança.
