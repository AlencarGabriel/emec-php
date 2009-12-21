#!/usr/bin/env php
<?php
/*
pegar o curso
pegar as paginas dos cursos
pegar as urls de cada pagina

*/


inicializa_diretorio_temporario();

$cursos = array('MATEMATICA', 'ENFERMAGEM', 'PSICOLOGIA');


foreach($cursos as $curso)
{
    echo "chamando um processo para {$curso}\n";
    
}









function inicializa_diretorio_temporario()
{
    $nome_dir = dirname(__FILE__) . '/tmp';
    
    
    
    if(is_dir($nome_dir))
    {
        echo "diretório temporario existe. Limpando...\n";
        $dir = dir($nome_dir);
        while (false !== ($arquivo = $dir->read())) {
            if($arquivo != '..' && $arquivo != '.')
                unlink($nome_dir.'/'.$arquivo);
        }
        $dir->close();
    } else {
        echo "diretório temporario não existe. Criando...\n";
        mkdir($nome_dir);
    }
}
