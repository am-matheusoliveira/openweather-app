# OpenWeatherMap - API Consult

Este projeto realiza o consumo de uma API Pública do OpenWeatherMap que retorna dados meteorológicos.</br>
Com ele, o usuário pode realizar consultas de previsão do tempo com base em uma cidade, ele foi desenvolvido com PHP, Laravel e MySQL. 

## Hospedado na Amazon AWS EC2
Este projeto esta hospedado na AWS você acessa-lo agora mesmo clicando no link: [OpenWeather App](http://ec2-52-67-60-157.sa-east-1.compute.amazonaws.com/openweather-app) 

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
![pagina-inicial](https://github.com/user-attachments/assets/571544ab-2ce1-4436-b033-b847d93246a1)
Nessa tela temos um formulário onde o usuário pode selecionar uma cidade (Somente cidades brasileiras) ou, caso ele prefira, basta digitar o nome de uma cidade.</br>
OBS: Os dados que aparecem na caixa de seleção são de um arquivo JSON fornecido pela própria Open Weather Map.

## Tela inicial - Mensagem de aviso
![pagina-inicial-mensagem-aviso](https://github.com/user-attachments/assets/5c327634-2117-44df-b326-9f3328cde800)
Caso o usuário tente realizar uma consulta sem ter fornecido uma cidade, o sistema o informará que o fornecimento de uma cidade é obrigatório.

## Tela de listagem das condições climáticas - Mensagem de Sucesso
![listagem-dos-dados-consuta-api-banco-de-dados-sucesso](https://github.com/user-attachments/assets/a4cfd2f4-1e62-4d9f-be00-b2259f6b43be)
Caso a consulta retorne sucesso, os dados são retornados para esta tela e uma mensagem de sucesso será mostrada para o usuário.</br>
Nesta tela, quando a consulta retornar sucesso, serão mostradas duas tabelas, uma que lista os dados da consulta atual que o usuário solicitou e a outra abaixo, se trata das consultas anteriores e também da consulta atual que o usuário fez.</br>
Também nesta tela, o usuário tem a opção de realizar filtros por qualquer coluna da tabela ou realizar ordenações dos dados por qualquer coluna, incluindo paginação dos dados.

## Tela de listagem das condições climáticas - Mensagem de Erro
![listagem-dos-dados-consulta-api-banco-de-dados-erro](https://github.com/user-attachments/assets/9d2ec223-55b1-4c5f-8301-c4d9d5f47371)
Caso a consulta retorne erro, uma mensagem de erro será mostrada para o usuário.</br>
Nesta tela, quando a consulta retorna erro, somente os dados já salvos no banco de dados serão mostrados.</br>
Também nesta tela, o usuário tem a opção de realizar filtros por qualquer coluna da tabela ou realizar ordenações dos dados por qualquer coluna, incluindo paginação dos dados.

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
