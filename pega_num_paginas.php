#!/usr/bin/env php
<?php

require_once('./utils.php');


if ( $argc < 2 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
    help();
    exit();
}

$pagina = curl(
    'http://emec.mec.gov.br/modulos/visao_cadastro/php/cadastroies/cadastro_cadastroies_consulta.php',
    array(
        'form'             => '1',
        'emec_next_page'   => 1,
        'rad_busca'        => '2',
        'txt_no_curso'     => $argv[1],
        'rad_tp_busca'     => '1',
        'hid_no_ies_value' => '',
        'sel_sg_uf'        => '',
        'sel_co_municipio' => '',
        'pager_id'         => ''
    )
);

$er = "/readonly value=\" de (.*?)\" size=7 maxlength=4/";
preg_match_all($er, $pagina, $matches);
$total_paginas = $matches[1][0];
fwrite(STDOUT, $total_paginas . PHP_EOL);

