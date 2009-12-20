<?php

define('DEBUG', true);
define('USERAGENT', 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.1.5) Gecko/20091109 Ubuntu/9.10 (karmic) Firefox/3.5.5');

if(DEBUG)
{
    error_reporting(-1);

} else {
    error_reporting(0);
}

function curl($url, $parametros = array())
{
    $par_serial = '';
    foreach($parametros as $chave => $valor)
    {
        $par_serial .= sprintf('%s=%s&', $chave, $valor);
    }
    $par_serial = trim($par_serial, '&');
    
    $opcoes = array(
        CURLOPT_URL        => $url,
        CURLOPT_POST       => count($parametros),
        CURLOPT_POSTFIELDS => $par_serial,
        CURLOPT_USERAGENT  => USERAGENT,
        CURLOPT_RETURNTRANSFER => true
    );
    /** Inicializa o curl */
    $curl = curl_init();
    
    curl_setopt_array($curl, $opcoes);
    
    /** pega o conteudo */
    $conteudo = curl_exec($curl);
    $conteudo = iconv('ISO-8859-1', '"UTF-8//TRANSLIT"', $conteudo);
    
    /** fecha o curl */
    curl_close($curl);
    
    return $conteudo;
}
