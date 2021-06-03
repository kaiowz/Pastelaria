##Observações

Antes de iniciar os comandos, será preciso criar uma base de dados no MySql e configurar o arquivo .env para os comandos do banco de dados rodarem.
Será preciso alterar as variáveis

DB_DATABASE=(Nome do banco de dados criado)
DB_USERNAME=(Configuração de usuário do MySql)
DB_PASSWORD=(Configuração de senha do MySql)

##Comandos
Entrar na pasta Backend e rodar o seguintes comandos:

php artisan migrate:fresh

php artisan db:seed

Esses comandos são responsáveis por inicializar o banco de dados e alimentar a tabela dos pasteis com os dados pré-estabelecidos.
