# Web Project

Este projeto é uma aplicação web desenvolvida em PHP. Abaixo estão as informações sobre a estrutura do projeto e como configurá-lo.

## Estrutura do Projeto

```
webproject
├── src
│   ├── index.php
│   ├── controllers
│   │   └── HomeController.php
│   ├── models
│   │   └── User.php
│   ├── views
│       └── home.php
├── public
│   ├── css
│   │   └── styles.css
│   ├── js
│       └── scripts.js
│   └── index.php
├── config
│   └── config.php
├── vendor
├── composer.json
└── README.md
```

## Instalação

1. Clone o repositório:
   ```
   git clone <URL_DO_REPOSITORIO>
   ```

2. Navegue até o diretório do projeto:
   ```
   cd webproject
   ```

3. Instale as dependências usando o Composer:
   ```
   composer install
   ```

## Uso

- O ponto de entrada público da aplicação é `public/index.php`. Acesse a aplicação através do seu servidor web configurado para apontar para o diretório `public`.

- As rotas e a lógica de controle estão localizadas em `src/controllers/HomeController.php`.

- Os modelos de dados estão em `src/models/User.php`.

- As visões são armazenadas em `src/views/home.php`.

## Contribuição

Sinta-se à vontade para contribuir com melhorias ou correções. Crie um fork do repositório e envie um pull request com suas alterações.

## Licença

Este projeto está licenciado sob a [Licença MIT](LICENSE).