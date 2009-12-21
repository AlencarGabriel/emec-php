#!/usr/bin/env php
<?php

require_once(dirname(__FILE__).'/utils.php');

if ( $argc < 2 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
    help();
    exit();
}

$pagina = curl($argv[1]);
fwrite(STDOUT, $pagina . PHP_EOL);

function help()
{
$help = <<<EOT
pega_instituicao.php URL

PARÃMETROS:
  URL: url para a página da instituição

DESCRIÇÃO:
  Recebe o link para a página de detalhes de uma instituição e retorna
  seu conteúdo html.

  Como o resultado deste script é apenas o html da página, isso não é muito
  útil, portanto, este script normalmente é usado em conjunto com o script

EXEMPLO:
  pega_instituicao.php `./pega_pagina.php matematica 1 | pega_urls.php | head -1`

EOT;

    echo $help;
}
