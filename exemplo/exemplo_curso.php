#!/usr/bin/env php
<?php

$curso = $argv[1];

$resultado = shell_exec("pega_num_paginas.php $curso");

var_dump($resultado);

/*
$total_paginas = 0;
$max = 5;

while(1)
{
    
}

*/
