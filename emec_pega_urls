#!/usr/bin/env php
<?php

require_once(dirname(__FILE__).'/utils.php');

main($argc, $argv);

function main($argc, $argv)
{
    $conteudo = file_get_contents('php://stdin');
    
    $er = "/;\" onclick=\"popup\( \'(.*)\' ,/";
    preg_match_all($er, $conteudo, $urls);
    $urls = $urls[1];
    
    foreach($urls as $url)
    {
        fwrite(STDOUT, $url . PHP_EOL);
    }
}
