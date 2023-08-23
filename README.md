<h4>Estrutura de Programação em PHP</h4>

-> Esta estrutura conta com alguns scripts para build, minificação e criação te templates

Uso dos Scripts<br>

<pre>
    composer make theme admin
</pre>
 
O comando acima gera na pasta View um tema padrão com o nome "admin" e também gera uma pasta dentro de src com os arquivos do tema

<pre>
    composer make resource Admin
</pre>

O comando acima gera um controlador, um serviço e adiciona o mesmo nas rotas

<pre>
    composer make resource Admin:admin
</pre>

O comando acima faz o mesmo que o anterior, porém especifica o tema a ser utilizado. Caso não passe nada o padrão é web

<pre>
    composer build
</pre>

<pre>
    npm run minify
</pre>

Comandos para fazer a minificação e compilação de todas os css e js do site para a pasta assets