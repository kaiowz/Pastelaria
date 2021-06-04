##Observações

Antes de iniciar os comandos, será preciso criar uma base de dados no MySql e configurar o arquivo .env para os comandos do banco de dados rodarem.
Será preciso alterar as variáveis

DB_DATABASE=(Nome do banco de dados criado)
DB_USERNAME=(Configuração de usuário do MySql)
DB_PASSWORD=(Configuração de senha do MySql)

O envio do e-mail foi realizado de um e-mail de teste, sendo assim as configurações do serviço segue abaixo. Contudo, é possível alterá-las para usar outro serviço que as configurações internas não irão ser alteradas.

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME= (login)
MAIL_PASSWORD= (senha do gmail)
MAIL_FROM_ADDRESS= (gmail usado)

Também será preciso ajustar as variáveis de envio de e-mail, para configurar o envio.

##Comandos
Entrar na pasta Backend e rodar o seguintes comandos:

php artisan migrate:fresh

php artisan db:seed

Esses comandos são responsáveis por inicializar o banco de dados e alimentar a tabela dos pasteis com os dados pré-estabelecidos.

Posteriormente basta rodar o servidor para ter acesso as rotas do Backend

php artisan serve
