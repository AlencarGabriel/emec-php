#!/usr/bin/env php
<?php

require_once(dirname(__FILE__).'/exemplo_utils.php');

$curso = $argv[1];

touch("./tmp/{$curso}_proc");

inicializa_diretorio("tmp/{$curso}");
inicializa_diretorio("tmp/{$curso}/pgs");

$qtd_paginas = shell_exec("pega_num_paginas.php $curso");

for($pg = 1; $pg <= $qtd_paginas; $pg++)
{
    touch("./tmp/{$curso}/pgs/$pg");
}

unlink("./tmp/{$curso}_proc");

