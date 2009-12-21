<?php

error_reporting(-1);

function inicializa_diretorio($nome)
{
    $nome_dir = dirname(__FILE__) . "/{$nome}";
    
    if( ! is_dir($nome_dir))
    {
        mkdir($nome_dir);
    }
}
