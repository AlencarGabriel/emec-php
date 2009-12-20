#!/usr/bin/env php
<?php

require_once('./utils.php');

$conteudo = file_get_contents('php://stdin');

$dados = array();

$er = '/<td class="subline2" colspan="3">([^#]*?)<\/td>/S';
preg_match_all($er, $conteudo, $matches);

$p1                          = trim($matches[1][0]);
$dados['natureza_juridica']  = trim($matches[1][1]);
$dados['email']              = trim($matches[1][2]);
$dados['educacao_distancia'] = trim($matches[1][3]);

// p1
$er = '/\((.*?)\)(.*?)\((.*?)\)/';
preg_match_all($er, $p1, $matches);
$dados['cnpj']        = trim($matches[1][0]);
$dados['mantenedora'] = trim($matches[2][0]);
$dados['codigo']      = trim($matches[3][0]);

$er = '/<td class="subline2" colspan="5">([^#]*?)<\/td>/S';
preg_match_all($er, $conteudo, $matches);
$p1 = trim($matches[1][0]);

$er = '/(.*?)\((.*?)\)/';
preg_match_all($er, $p1, $matches);
$dados['nome_ies']   = trim($matches[1][0]);
$dados['codigo_ies'] = trim($matches[2][0]);

$er = '/<td class="subline2">([^#]*?)<\/td>/S';
preg_match_all($er, $conteudo, $matches);

$dados['endereco']              = trim($matches[1][0]);
$dados['endereco_complemento']  = trim($matches[1][1]);
$dados['endereco_cep']          = trim($matches[1][2]);
$dados['endereco_bairro']       = trim($matches[1][3]);
$dados['endereco_cidade_uf']    = trim($matches[1][4]);
$dados['endereco_uf']           = trim($matches[1][4]);

$dados['telefone']              = trim($matches[1][5]);
$dados['organizacao_academica'] = trim($matches[1][6]);
$dados['site']                  = trim($matches[1][7]);
$dados['contato']               = trim($matches[1][8]);

$matches = split('/', $dados['endereco_cidade_uf']);
$dados['endereco_municipio'] = trim($matches[0]);
$dados['endereco_uf']        = trim($matches[1]);

$er = '/<td class="subline2" colspan="4">([^#]*?)<\/td>/S';
preg_match_all($er, $conteudo, $matches);
$dados['endereco_numero'] = trim($matches[1][0]);
$dados['fax']             = trim($matches[1][1]);

$conteudo = '';
foreach($dados as $dado)
{
    $conteudo .= $dado . "\t";
}
$conteudo = trim($conteudo, '|');

fwrite(STDOUT, $conteudo . PHP_EOL);



