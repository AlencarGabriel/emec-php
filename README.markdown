# Emec Crawler #

Uma série de pequenos scripts em PHP para conectar no site do 
[e-mec]{http://emec.mec.gov.br/ "site do e-mec"} e capturar
todas as instituições que oferecem o curso pesquisado.

## Introdução ##

Para entender como estes scripts funcionam é importante saber como o site emec
funciona.

Ao entrar no site, você encontrará um formulário para efetuar sua pesquisa.
O que gostariamos de pegar é todas as instituições no Brasil que oferece um 
determinado curso. Por exemplo: enfermagem.

No formulário, na opção "Buscar por", escolhemos "curso". Preenchemos o campo
"Curso" com a palavra "enfermagem" e mantemos todas as opções em branco para 
efetuar uma busca completa.

## Scripts ##

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
