<h2>Observações</h2>

Antes de iniciar os comandos, será preciso criar uma base de dados no MySql e configurar o arquivo .env para os comandos do banco de dados rodarem.
Será preciso alterar as variáveis

<p>DB_DATABASE=(Nome do banco de dados criado)</p>
<p>DB_USERNAME=(Configuração de usuário do MySql)</p>
<p>DB_PASSWORD=(Configuração de senha do MySql)</p>

O envio do e-mail foi realizado de um e-mail de teste, sendo assim as configurações do serviço segue abaixo. Contudo, é possível alterá-las para usar outro serviço que as configurações internas não irão ser alteradas.

<p>MAIL_MAILER=smtp</p>
<p>MAIL_HOST=smtp.gmail.com</p>
<p>MAIL_PORT=587</p>
<p>MAIL_USERNAME= (login)</p>
<p>MAIL_PASSWORD= (senha do gmail)</p>
<p>MAIL_FROM_ADDRESS= (gmail usado)</p>

Também será preciso ajustar as variáveis de envio de e-mail, para configurar o envio.

<h2>Comandos</h2>
<p>Entrar na pasta Backend e rodar o seguintes comandos:</p>

<p>php artisan migrate:fresh</p>

<p>php artisan db:seed</p>

Esses comandos são responsáveis por inicializar o banco de dados e alimentar a tabela dos pasteis com os dados pré-estabelecidos.

Posteriormente basta rodar o servidor para ter acesso as rotas do Backend

php artisan serve
