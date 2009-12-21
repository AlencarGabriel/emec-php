#!/usr/bin/env php
<?php

require_once(dirname(__FILE__).'/utils.php');

if ( $argc < 3 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
    help();
    exit();
}

$pagina = curl(
    'http://emec.mec.gov.br/modulos/visao_cadastro/php/cadastroies/cadastro_cadastroies_consulta.php',
    array(
        'form'             => '1',
        'emec_next_page'   => $argv[2],
        'rad_busca'        => '2',
        'txt_no_curso'     => $argv[1],
        'rad_tp_busca'     => '1',
        'hid_no_ies_value' => '',
        'sel_sg_uf'        => '',
        'sel_co_municipio' => '',
        'pager_id'         => ''
    )
);

fwrite(STDOUT, $pagina . PHP_EOL);



function help()
{
$help = <<<EOT
pega_pagina.php CURSO PAGINA

PARÃMETROS:
  CURSO: nome do curso desejado
  PAGINA: número da página que deve ser pega

DESCRIÇÃO:
  Passando o curso desejado e a página, este script se conectará
  no site do emec e pegará uma página html contendo os links das instituições.
  São 15 links por página.

  Como é preciso informar qual página deve ser pegada, este script é melhor
  chamado dentro de um laço.

EXEMPLO:
  pega_pagina.php matematica 1

EOT;

    echo $help;
}
