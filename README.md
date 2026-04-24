# Akiba V2

## Portugues

Akiba V2 e uma aplicacao Laravel para gerenciar uma plataforma de comunidade/radio com foco em cultura anime. O projeto combina uma experiencia publica com player e pedidos de musica, alem de um painel privado para conteudo, programacao, locucao, midia, marketing, usuarios, permissoes e tarefas operacionais.

### Stack

- **Back-end:** PHP 8.2, Laravel 12, Laravel Sanctum
- **Front-end:** Inertia.js, Svelte, Vite, Tailwind CSS 4
- **Banco de dados:** MySQL
- **Assets e midia:** Intervention Image
- **Ferramentas:** PHPUnit, Laravel Pint, Laravel Pail

### Principais recursos

- Pagina publica com player e suporte a pedidos de musica
- Painel privado com autenticacao
- Dashboard com atividades e conclusao de tarefas
- Gestao de posts, reviews, eventos, podcasts, midias e materiais de marketing
- Gestao de radio com programas, ranking musical, ouvinte do mes e pedidos de musica
- Fluxo de locucao para iniciar e finalizar transmissoes
- Area administrativa para usuarios, cargos, permissoes, calendario, atividades, tarefas e programas automaticos
- Gerenciamento de perfil
- Endpoints de cast para redirecionamento de stream e metadados
- Integracao com webhook do Discord para eventos da stream

### Requisitos

- PHP 8.2+
- Composer
- Node.js e npm
- MySQL
- Redis opcional, dependendo da configuracao local de cache/sessao

### Instalacao

Clone o repositorio e instale as dependencias PHP e JavaScript:

```bash
composer install
npm install
```

Crie o arquivo de ambiente e gere a chave da aplicacao:

```bash
cp .env.example .env
php artisan key:generate
```

Configure o banco de dados no `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=akiba
DB_USERNAME=root
DB_PASSWORD=
```

Depois execute as migrations:

```bash
php artisan migrate
```

### Desenvolvimento

Execute o ambiente local completo:

```bash
composer run dev
```

Esse comando inicia o servidor Laravel, o listener da fila, os logs com Pail e o servidor Vite.

Tambem e possivel rodar as partes separadamente:

```bash
php artisan serve
npm run dev
php artisan queue:listen
```

### Build

Gere o build de producao do front-end:

```bash
npm run build
```

### Testes

Execute a suite de testes:

```bash
composer test
```

Ou diretamente pelo Artisan:

```bash
php artisan test
```

### Rotas uteis

- `/` - home/player publico provisorio
- `/site` - rota publica do site
- `/panel` - login do painel
- `/panel/dashboard` - dashboard privado
- `/panel/radio` - gestao de radio
- `/panel/locution` - area de locucao
- `/panel/administration` - area administrativa
- `/api/cast` - redirecionamento da stream
- `/api/cast/metadata` - metadados da stream

### Variaveis de ambiente

O projeto inclui variaveis extras para integracoes de stream e Discord:

```env
CAST_URL=null
CAST_METADATA=null
DISCORD_STREAM_WEBHOOK=null
```

Defina esses valores quando quiser conectar a aplicacao local a metadados reais da stream ou a notificacoes via webhook.

### Estrutura do projeto

- `app/Actions` - casos de uso agrupados por dominio
- `app/Http/Controllers` - controllers publicos, privados, API e provisorios
- `app/Http/Requests` - validacoes de formulario
- `app/Http/Resources` - formatacao de respostas e resources
- `app/Models` - models Eloquent
- `app/Policies` - regras de autorizacao
- `app/Services` - servicos externos e de processamento
- `resources/js/pages` - paginas Inertia/Svelte
- `resources/js/ui` - componentes, layouts e widgets reutilizaveis
- `routes/web` - rotas web separadas por contexto

### Licenca

Este projeto e open-source sob a licenca MIT.

---

## English

Akiba V2 is a Laravel application for managing a radio/community platform focused on anime culture. It combines a public player experience with song requests and a private control panel for content, programming, locution, media, marketing assets, users, permissions, and operational tasks.

### Stack

- **Backend:** PHP 8.2, Laravel 12, Laravel Sanctum
- **Frontend:** Inertia.js, Svelte, Vite, Tailwind CSS 4
- **Database:** MySQL
- **Assets and media:** Intervention Image
- **Tooling:** PHPUnit, Laravel Pint, Laravel Pail

### Main features

- Public page with player and song request support
- Private panel with authentication
- Dashboard with activities and task completion
- Post, review, event, podcast, media, and marketing management
- Radio management for programs, music ranking, listener of the month, and song requests
- Locution flow for starting and finishing broadcasts
- Administration area for users, roles, permissions, calendars, activities, tasks, and automatic programs
- Profile management
- Cast endpoints for stream redirect and metadata
- Discord webhook integration for stream events

### Requirements

- PHP 8.2+
- Composer
- Node.js and npm
- MySQL
- Redis is optional depending on your local cache/session configuration

### Installation

Clone the repository and install the PHP and JavaScript dependencies:

```bash
composer install
npm install
```

Create the environment file and generate the Laravel app key:

```bash
cp .env.example .env
php artisan key:generate
```

Configure your database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=akiba
DB_USERNAME=root
DB_PASSWORD=
```

Then run the migrations:

```bash
php artisan migrate
```

### Development

Run the full local development stack:

```bash
composer run dev
```

This starts the Laravel server, queue listener, Laravel Pail logs, and Vite dev server together.

You can also run the pieces separately:

```bash
php artisan serve
npm run dev
php artisan queue:listen
```

### Build

Create a production frontend build:

```bash
npm run build
```

### Tests

Run the test suite:

```bash
composer test
```

Or run Artisan directly:

```bash
php artisan test
```

### Useful routes

- `/` - provisional public home/player
- `/site` - public site route
- `/panel` - panel login
- `/panel/dashboard` - private dashboard
- `/panel/radio` - radio management
- `/panel/locution` - locution area
- `/panel/administration` - administration area
- `/api/cast` - cast stream redirect
- `/api/cast/metadata` - cast metadata

### Environment notes

The project includes extra environment variables for stream and Discord integrations:

```env
CAST_URL=null
CAST_METADATA=null
DISCORD_STREAM_WEBHOOK=null
```

Set these values when you want to connect the local app to real stream metadata or webhook notifications.

### Project structure

- `app/Actions` - application use cases grouped by domain
- `app/Http/Controllers` - public, private, API, and provisional controllers
- `app/Http/Requests` - form request validation
- `app/Http/Resources` - API/resource response formatting
- `app/Models` - Eloquent models
- `app/Policies` - authorization rules
- `app/Services` - external and processing services
- `resources/js/pages` - Inertia/Svelte pages
- `resources/js/ui` - reusable UI components, layouts, and widgets
- `routes/web` - web routes split by context

### License

This project is open-sourced under the MIT license.
