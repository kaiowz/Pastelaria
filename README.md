<h2>Introdução</h2>
<p>A API foi construída atendendo os requisitos do teste. Inclui a necessidade de ter um cliente logado para poder realizar um pedido, reforçando a regra de negócio.</p>
<p>Tinha a ideia de construir o front end, mas acabou não sendo desenvolvido por algumas complicações que passei com a internet na outra casa, acarretando na mudanças de moradia.</p>

<h2>Observações</h2>
<p>Antes de iniciar os comandos, será preciso criar uma base de dados no MySql e configurar o arquivo .env para os comandos do banco de dados rodarem.
Será preciso alterar as variáveis</p>

<p>DB_DATABASE=(Nome do banco de dados criado)</p>
<p>DB_USERNAME=(Configuração de usuário do MySql)</p>
<p>DB_PASSWORD=(Configuração de senha do MySql)</p>

<p>O envio do e-mail foi realizado por um e-mail de teste, sendo assim as configurações do serviço segue abaixo. Contudo, é possível alterá-las para usar outro serviço que as configurações internas não irão ser alteradas.</p>

<p>MAIL_MAILER=smtp</p>
<p>MAIL_HOST=smtp.gmail.com</p>
<p>MAIL_PORT=587</p>
<p>MAIL_USERNAME= (login)</p>
<p>MAIL_PASSWORD= (senha do gmail)</p>
<p>MAIL_FROM_ADDRESS= (gmail usado)</p>

<p>Também será preciso ajustar as variáveis de envio de e-mail, para configurar o envio.</p>

<h2>Comandos</h2>
<p>Entrar na pasta Backend e rodar o seguintes comandos:</p>

<p><strong>php artisan migrate:fresh</strong></p>

<p><strong>php artisan db:seed</strong></p>

<p>Esses comandos são responsáveis por inicializar o banco de dados e alimentar a tabela dos pasteis com os dados pré-estabelecidos.</p>

<p>Posteriormente basta rodar o servidor para ter acesso as rotas do Backend</p>

<p><strong>php artisan serve</strong></p>
