# OpenWeatherMap - API Consult

Este projeto realiza o consumo de uma API Pública do OpenWeatherMap que retorna dados meteorológicos.</br>
Com ele, o usuário pode realizar consultas de previsão do tempo com base em uma cidade, ele foi desenvolvido com PHP, Laravel e MySQL. 

### Ferramentas
* PHP 8.0
* MySQL
* Laravel 11
* Bootstrap 5
* Jquery
* Plugin DataTables
* Plugin Select2

### Imagens do Sistema
## Tela inicial
Nessa tela temos um formulario onde o usuário pode selecionar uma Cidade(Somente cidades brasileiras) ou caso ele prefira, basta digitar o nome de uma Cidade.</br>
OBS: Os dados que aparecem na caixa de seleção são de um arquivo JSON fornecido pela propria Open Weather Map.

## Tela inicial - Mensagem de aviso
Caso o usuário tente realizar uma consuta sem ter fornecido uma Cidade o sistema o informara que o forncimento de uma cidade e obrigaorio.

## Tela de listagem das consições climaticas - Mensagem de Sucesso
Caso a consuta retorne sucesso os dados são retornados para esta tela e uma mensagem de Sucesso sera mostrada para o usuário.</br>
Nesta tela, quando a consuta retornar sucesso aprece-ra duas tabelas uma que lista os dados da consulta atual que o usuário solicitou e a outra abaixo se trata das consutas anteriores e também da consulta atual que p usuário fez.</br>
Também nesta tela o usuário tem a opção de realizar filtros por qualquer coluna da tabela ou realizar ordenações dos dados por qualquer coluna, incluindo páginação dos dados.

## Tela de listagem das condições climaticas - Mensagem de Erro
Caso a consuta retorne erro uma mensagem de Erro sera mostrada para o usuário.</br>
Nesta tela, quando a consuta retorna erro somente a os dados já salvos no banco de dados seram msotrado.</br>
Também nesta tela o usuário tem a opção de realizar filtros por qualquer coluna da tabela ou realizar ordenações dos dados por qualquer coluna, incluindo páginação dos dados.


## Tela inicial


### Instalação
Siga os passos abaixo para configurar e executar o projeto em sua máquina local.
### 1. Clonar o Repositório
```
git clone https://github.com/am-matheusoliveira/openweather-app.git
cd openweather-app
```
### 2. Instalar Dependências
```
composer install
```
### 3. Configurar o Arquivo `.env`
Crie um arquivo `.env` a partir do `.env.example` e configure as variáveis de ambiente.</br>
```
cp .env.example .env
```
Edite o arquivo `.env` para incluir suas configurações de banco de dados, use este exemplo:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seu_banco_de_dados - para este aplicativo o nome é: open_weather
DB_USERNAME=seu_usuario - para este aplicativo o usuário é: root
DB_PASSWORD=sua_senha - para este aplicativo a senha: 
```
### 4. Gerar a Chave da Aplicação
```
php artisan key:generate
```
### 5. Criar o Banco de Dados - Sistema
Em seu Gerenciador de Banco de Dados execute o script SQL que esta na pasta `database-app/script-database.sql` para criar o Banco de Dados e a Tabela de Cidades.

### 6. Migrar o Banco de Dados - Tabelas do Laravel e do Aplicativo
```
php artisan migrate
```
### 7. Acessando o Aplicativo
O aplicativo estará disponível em `http://localhost/openweather-app`.<br>

### Conclusão

Este projeto demonstra minhas habilidades no desenvolvimento de Aplicativos com PHP, Laravel e MySQL, incluindo:
* Desenvolvimento da interface do usuário para interagir com o sistema
* Manipulação de respostas em formato JSON
* Consumo de API's usando o Framework Laravel
* Modelagem de dados usando os recursos do Framework
* Manipulação de Banco de Dados SQL
---
Sinta-se à vontade para explorar o código e fazer melhorias.<br>
Se tiver alguma dúvida, entre em contato.
