#!/usr/bin/env php
<?php

require_once(dirname(__FILE__).'/utils.php');

if ( $argc > 1 && in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
    help();
    exit();
}

$conteudo = file_get_contents('php://stdin');

$er = "/;\" onclick=\"popup\( \'(.*)\' ,/";
preg_match_all($er, $conteudo, $urls);
$urls = $urls[1];

foreach($urls as $url)
{
    fwrite(STDOUT, $url . PHP_EOL);
}

function help()
{
$help = <<<EOT
pega_urls.php

DESCRIÇÃO:
  Extrai de uma página que já foi antes recuperada retornando todos os links
  para as informações de uma instituição.

EXEMPLO:
  pega_pagina.php matematica 1 | pega_urls.php | head -1

EOT;

    echo $help;
}
