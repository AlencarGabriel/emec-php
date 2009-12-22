Ultima alteração feita em: 22 de Dezembro de 2009

# Emec PHP #

Uma série de pequenos scripts em PHP para conectar no site do 
[e-mec](http://emec.mec.gov.br/ "site do e-mec") e capturar
todas as instituições que oferecem o curso pesquisado.

## Licença ##
Este projeto está licenciado com as mesmas condições de uma licença no estilo BSD.
O arquivo contendo a licença está na raiz do projeto com o nome
de "LICENCE.markdown".

Resumindo: Você pode pegar, usar e fazer o que quiser mas não pode me culpar se
algo der errado. A única coisa que você deve fazer para estar dentro da lei é 
dar os devidos créditos para o criador deste projeto.

De toda maneira, o que vale é o que está escrito na licença, então, é bom dar
uma olhada.

## Introdução ##

Para entender como estes scripts funcionam é importante saber como o site emec
funciona.

Ao entrar no [site do e-mec](http://emec.mec.gov.br/ "site do e-mec"), 
você encontrará um formulário para efetuar sua pesquisa.
O que gostaríamos de pegar é todas as instituições no Brasil que oferece um 
determinado curso. Por exemplo: enfermagem.

No formulário, na opção "Buscar por", escolhemos "curso", preenchemos o campo
"Curso" com a palavra "enfermagem" e mantemos todas as opções em branco para 
efetuar uma busca completa.

Ao pressionar o botão "consultar", o site carrega a lista de instituições
que queríamos. Como são muitas instituições, o resultado é mostrado dividido 
em páginas. Estas páginas são muito importantes.
Cada entrada de uma página contém o nome da instituição e um link para a página
dos detalhes da instituição como o endereço por exemplo.

É possível recuperar estas informações detalhadas sobre as instituições de
ensino que lecionam determinado curso com os scripts que você encontra aqui.

## Instalação ##
Baixe a última versão:

*   [formato zip](http://github.com/tarcisio/emec-php/zipball/master "Download na versão zip")
*   [formato tar.gz](http://github.com/tarcisio/emec-php/tarball/master "Download na versão tar.gz")

Ou clone o código-fonte:

    $ git clone git://github.com/tarcisio/emec-php.git emec-php

dentro do diretório, execute o comando "__make install__". Por padrão os scripts
serão instalados no diretório: "/usr/local/emec-php". Você pode alterar o local
editando o arquivo Makefile:

    # altere a variável prefix com o caminho desejado
    PREFIX=/usr/local/emec-php

Você pode chamar cada script com o caminho completo para o arquivo ou pode
adicionar o diretório _PREFIX_/bin no PATH do sistema.

__Veja um exemplo completo:__

    
    $ git clone git://github.com/tarcisio/emec-php.git emec-php
    $ cd emec-php
    $ sudo make install
    $ export PATH=$PATH:/usr/local/emec-php/bin

Quando reiniciar seu computador, o PATH voltará o que era antes de você editá-lo.
Para manter a alteração, faça a mudança no seu arquivo .bash_profile, colocando
na ultima linha:

    PATH=$PATH:/usr/local/emec-php/bin

## Scripts ##

Todo o trabalho é dividido em diferentes scripts. Cada um exerce uma tarefa 
distinta. Poderia ser um único script que fizesse todo o trabalho, porém, 
existem motivos para quebrá-lo em arquivos menores:

__Simplifica o desenvolvimento__: Escrever um código que executa apenas uma tarefa
é muito mais simples. É menos problemas para se pensar. Basta saber o
que vai entrar e em como reproduzir a saída esperada.

__Trabalhar de forma paralelizada__:Escrevendo um script único processo e em uma
única thread impossibilita usar o máximo da capacidade de processamento de um
computador moderno com múltiplos núcleos. No PHP não é possível trabalhar com
threads, então, criei as tarefas separadamente e assim posso chamar a quantidade
de cada uma no momento que eu quiser. Quando pedimos uma página,
esta retorna vários links. Ao invés de processar cada um após o outro, podemos
processar até todos de uma vez. Sendo recomendado ter a quantidade de processos
rodando igual ao número de núcleos do(s) processador(es)

### Pseudo-código ###

Uso simplificado dos scripts:

    #
    # Uso dos scripts de forma sequencial
    #
    cursos = ["engenharia", "matemática"]
    FOREACH cursos AS curso
        total_paginas = pega_num_paginas(curso)
        FOR pagina FROM 1 TO total_paginas
            conteudo = pega_pagina(curso, pagina)
            urls = pega_urls(conteudo)
            FOREACH urls as url
                instituicao = pega_instituicao(url)
                dados = extrai_instituicao(instituicao)
                escreve(dados)

### pega_num_paginas CURSO  
__Parâmetros:__

1.   CURSO: nome do curso desejado

__Descrição e Uso:__  
Pega a quantidade de páginas contendo urls para um determinado curso.

Este comando é útil para ser usado em um laço com o programa __pega_pagina__.

    # Ex 1:
    # pega a ultima pagina de um curso
    # note o uso de "`" para pegar primeiro o resultado do comando
    # para ser passado para o script anterior
    
    pega_pagina matematica `pega_num_paginas matematica`

### pega_pagina CURSO PAGINA  

__Parâmetros:__

1.   CURSO: nome do curso desejado
2.   PAGINA: número da página que deve ser pega

__Descrição e Uso:__  
Passando o curso desejado e a página, este script se conectará no site do
emec e pegará uma página html contendo os links das instituições.
São 15 links por página.

Como é preciso informar qual página deve ser chamada, este script é melhor
usado dentro de um laço.

    # Ex 1:
    # pega a primeira página do curso de enfermagem
    
    pega_pagina enfermagem 1
    
    # Ex 2:
    # pega a primeira página do curso de matemática e salva em um arquivo
    # note o redirecionamento da saída para o arquivo com o ">"
    
    pega_pagina matematica 1 > matematica_pg1.html
    

Normalmente a saída deste programa é redirecionada para a entrada do script
__pega_url__.


### pega_urls
__Parâmetros:__  
Não possui parâmetros. Recebe o conteúdo direto da entrada padrão STDIN.

__Descrição e Uso:__  
Extrai de uma página que já foi antes recuperada retornando todos os links
para as informações de uma instituição.

    # Ex 1:
    # pega o primeiro link da primeira página do curso de matematica
    # note o uso de pipes "|" e do comando unix "head"
    # o head retorna o número de linhas desejados de cima para baixo (é o head)
    # no caso foi pedido apenas 1 linha: "head -1"
    
    pega_pagina matematica 1 | pega_urls | head -1

### pega_instituicao URL
__Parâmetros:__

1.   URL: url para a página da instituição

__Descrição e Uso:__  
Recebe o link para a página de detalhes de uma instituição e retorna seu conteúdo
html.

Como o resultado deste script é apenas o html da página, isso não é muito útil,
portanto, este script normalmente é usado em conjunto com o 
script __extrai_instituicao__.


### extrai_instituicao
__Parâmetros:__  
Este script não recebe parâmetros. Apenas recebe o conteúdo direto da entrada
padrão STDIN.

__Descrição e Uso:__  
Extrai de uma página de uma instituição todas as informações úteis e retorna em
uma única linha com os campos separados por TAB.

Com o uso dos scripts anteriores é possível escrever em um arquivo único tabulado.

    # Ex 1:
    # pega a primeira instituição do curso de matemática e salva em um arquivo
    # note que foi quebrado a linha em duas com a barra "\"
    
    pega_instituicao `./pega_pagina matematica 1 \
    | pega_urls | head -1` | extrai_instituicao



