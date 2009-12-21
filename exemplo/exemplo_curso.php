#!/usr/bin/env php
<?php

require_once(dirname(__FILE__).'/exemplo_utils.php');

$curso = $argv[1];

touch("./tmp/{$curso}");

$qtd_paginas = shell_exec("pega_num_paginas.php $curso");

for($pg = 1; $pg <= $qtd_paginas; $pg++)
{
    echo "criando o arquivo para a pagina {$pg}\n";
    touch("./tmp/{$curso}_pg_{$pg}");
}

unlink("./tmp/{$curso}");

