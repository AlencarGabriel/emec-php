# Emec Crawler #

Uma série de pequenos scripts em PHP para conectar no site do 
[e-mec](http://emec.mec.gov.br/ "site do e-mec") e capturar
todas as instituições que oferecem o curso pesquisado.

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
em páginas.

Cada entrada de uma página contém o nome da instituição e o mais importante: Um
link para a página contendo os detalhes da instituição como o endereço por exemplo.
E estes são os dados que podem ser capturados usando os scripts que aqui estão.


## Scripts ##

Todo o trabalho é dividido em diferentes scripts. Cada um exerce uma tarefa 
distinta. Poderia ser um único script que fizesse todo o trabalho, porém, 
existem motivos para quebrá-lo em arquivos menores:

__Simplifica o desenvolvimento__: Escrever um código que executa apenas uma tarefa
é muito mais simples. É menos problemas para se pensar. Basta saber o
que vai entrar e em como reproduzir a saída esperada.

__Possibilita trabalhar de forma paralelizada__: Escrevendo um script único
impossibilita usar o máximo da capacidade de processamento de um computador moderno
com múltiplos núcleos. Sim, é possível usar este potêncial em outras linguagens, 
mas no PHP não é possível. Então, criei as tarefas separadamente e assim posso
chamar a quantidade de cada um no momento que eu quiser.

> ### Pseudo-código ###
> 
>    cursos = ["engenharia", "matemática"]
>    FOREACH cursos AS curso
>        total_paginas = pega_num_paginas(curso)
>        FOR pagina FROM 1 TO total_paginas
>            conteudo = pega_pagina(curso, pagina)
>            urls = pega_urls(conteudo)
>            FOREACH urls as url
>                instituicao = pega_instituicao(url)
>                dados = extrai_instituicao(instituicao)

pega_pagina (curso) (pagina)

Passando o curso desejado e a página, este script se conectará no site do
emec e pegará uma página contendo um link para cada instituição da página.
São 15 links por página.

Usado em conjunto com o script *pega_url*.


pega_urls

Extrai de uma página que já foi antes recuperada e retorna todos os links
para as informações de uma instituição.


pega_instituicao

Recebe o link para a página de detalhes de uma instituição e retorna seu conteudo.

Usado em conjunto com o script *extrai_instituicao*.


extrai_instituicao

Extrai de uma página de uma instituição todas as informações úteis e retorna em
uma linha única com os campos separados por <TAB>.



  ./pega_instituicao `./pega_pagina FERMAGEM 1 | ./pega_urls | head -1` | ./extrai_instituicao
