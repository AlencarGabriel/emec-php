#!/usr/bin/env php
<?php

error_reporting(-1);

$cursos = array('PSICOLOGIA');

// Para cada curso
foreach($cursos as $curso)
{
    // abre o arquivo que armazenará os dados
    $arquivo = fopen($argv[1] . "_{$curso}", "w");
    
    // pega o total de paginas do curso
    $total_paginas = exec("pega_num_paginas.php $curso");
    
    // para cada pagina
    for($pagina = 1; $pagina <= $total_paginas; $pagina++)
    {
        // pega o conteudo de uma pagina
        $conteudo = shell_exec("pega_pagina.php {$curso} {$pagina}");
        
        // pega as urls
        $descritor = array(
            array("pipe", "r"),
            array("pipe", "w"),
            array("pipe", "w")
        );
        
        $processo = proc_open("pega_urls.php", $descritor, $pipes);
        if (is_resource($processo))
        {
            fwrite($pipes[0], $conteudo);
            fclose($pipes[0]);
            
            $urls = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            
            proc_close($processo);
            
            $urls = preg_split("/\s+/", $urls);
            
            // para cada url
            for($url = 0; $url < count($urls) - 1; $url++)
            {
                // pega uma instituicao
                $instituicao = shell_exec('pega_instituicao.php ' . $urls[$url]);
                echo $instituicao;
                
                // pega os dados tabulados de uma instituicao
                $processo = proc_open("extrai_instituicao.php", $descritor, $pipes);
                if (is_resource($processo))
                {
                    fwrite($pipes[0], $instituicao);
                    fclose($pipes[0]);
                    
                    $tabulado = stream_get_contents($pipes[1]);
                    fclose($pipes[1]);
                    fclose($pipes[2]);
                    
                    proc_close($processo);
                    
                    // log
                    //echo "{$curso} {$pagina} {$url}\n";
                    
                    // escreve no arquivo
                    fwrite($arquivo, $pagina ."\t". $url ."\t". $tabulado);
                    
                    sleep(5);
                }
            }
        }
    }
    
    fclose($arquivo);
}

