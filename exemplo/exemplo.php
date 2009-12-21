#!/usr/bin/env php
<?php
/*
pegar o curso
pegar as paginas dos cursos
pegar as urls de cada pagina

*/

require_once(dirname(__FILE__).'/exemplo_utils.php');

inicializa_diretorio('tmp');


$cursos = array('MATEMATICA', 'ENFERMAGEM', 'PSICOLOGIA');

foreach($cursos as $curso)
{
    echo "chamando um processo para {$curso}\n";
    exec("./exemplo_curso.php $curso > /dev/null &");
}

sleep(2);
    
while(1)
{
    if( ! file_exists("./tmp/MATEMATICA_proc"))
    {
        inicializa_diretorio("tmp/$curso/pgs_rodando");
        //exec("./exemplo_conteudo.php $curso > /dev/null &");
        break;
    }
}

