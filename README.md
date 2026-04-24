<div align="center">
  <img src="https://i.imgur.com/WbKAm6A.png" alt="Akiba V2" width="500" />
</div>

Segunda versão (2026) do portal de notícias e web-rádio da Rede Akiba. Trazendo uma nova experiência para os fãs da cultura japonesa desde 2016.

## Português

Akiba V2 é uma aplicação Laravel para gerenciar uma plataforma de comunidade e rádio com foco em cultura anime. O projeto combina uma experiência pública com player e pedidos de música, além de um painel privado para conteúdo, programação, locução, mídia, marketing, usuários, permissões e tarefas operacionais.

### Stack

- **Back-end:** PHP 8.2, Laravel 12, Laravel Sanctum
- **Front-end:** Inertia.js, Svelte, Vite, Tailwind CSS 4
- **Banco de dados:** MySQL
- **Assets e mídia:** Intervention Image
- **Ferramentas:** PHPUnit, Laravel Pint, Laravel Pail

### Principais recursos

- Página pública com player e suporte a pedidos de música
- Painel privado com autenticação
- Dashboard com atividades e conclusão de tarefas
- Gestão de posts, reviews, eventos, podcasts, mídias e materiais de marketing
- Gestão de rádio com programas, ranking musical, ouvinte do mês e pedidos de música
- Fluxo de locução para iniciar e finalizar transmissões
- Área administrativa para usuários, cargos, permissões, calendário, atividades, tarefas e programas automáticos
- Gerenciamento de perfil
- Endpoints de cast para redirecionamento de stream e metadados
- Integração com webhook do Discord para eventos da stream

### Requisitos

- PHP 8.2+
- Composer
- Node.js e npm
- MySQL
- Redis opcional, dependendo da configuração local de cache/sessão

### Instalação

Clone o repositório e instale as dependências PHP e JavaScript:

```bash
composer install
npm install
```

Crie o arquivo de ambiente e gere a chave da aplicação:

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

Para preparar o banco com dados iniciais, execute as seeders:

```bash
php artisan db:seed
```

Em um ambiente local novo, você também pode recriar o banco e popular tudo em um único comando:

```bash
php artisan migrate:fresh --seed
```

As seeders cadastram permissões, cargos, usuários, atividades, programas, conteúdos, podcasts, rádio, enquetes, pedidos musicais e outros dados de desenvolvimento. O usuário administrador local criado pela seeder é:

```text
Usuário: admin
Senha: admin
```

### Desenvolvimento

Execute o ambiente local completo pelo comando personalizado:

```bash
php artisan dev
```

Esse comando inicia o servidor Laravel, o listener da fila, os logs com Laravel Pail e o servidor Vite.

Também é possível rodar as partes separadamente:

```bash
php artisan serve
npm run dev
php artisan queue:listen
```

### Comandos personalizados

### Build

Gere o build de produção do front-end:

```bash
npm run build
```

### Testes

Execute a suíte de testes:

```bash
php artisan test
```

### Rotas úteis

- `/` - home/player público provisório
- `/site` - rota pública do site
- `/panel` - login do painel
- `/panel/dashboard` - dashboard privado
- `/panel/radio` - gestão de rádio
- `/panel/locution` - área de locução
- `/panel/administration` - área administrativa
- `/api/cast` - redirecionamento da stream
- `/api/cast/metadata` - metadados da stream

### Variáveis de ambiente

O projeto inclui variáveis extras para integrações de stream e Discord:

```env
CAST_URL=null
CAST_METADATA=null
DISCORD_STREAM_WEBHOOK=null
```

Defina esses valores quando quiser conectar a aplicação local a metadados reais da stream ou a notificações via webhook.

### Estrutura do projeto

- `app/Actions` - casos de uso agrupados por domínio
- `app/Console/Commands` - comandos Artisan personalizados
- `app/Http/Controllers` - controllers públicos, privados, API e provisórios
- `app/Http/Requests` - validações de formulário
- `app/Http/Resources` - formatação de respostas e resources
- `app/Models` - models Eloquent
- `app/Policies` - regras de autorização
- `app/Services` - serviços externos e de processamento
- `database/seeders` - dados iniciais e registros de desenvolvimento
- `resources/js/pages` - páginas Inertia/Svelte
- `resources/js/ui` - componentes, layouts e widgets reutilizáveis
- `routes/web` - rotas web separadas por contexto

### Licença

Este projeto é open-source sob a licença MIT.

---

## English

Akiba V2 is a Laravel application for managing a community and radio platform focused on anime culture. The project combines a public player experience with song requests and a private control panel for content, programming, live hosting, media, marketing assets, users, permissions, and operational tasks.

### Stack

- **Backend:** PHP 8.2, Laravel 12, Laravel Sanctum
- **Frontend:** Inertia.js, Svelte, Vite, Tailwind CSS 4
- **Database:** MySQL
- **Assets and media:** Intervention Image
- **Tooling:** PHPUnit, Laravel Pint, Laravel Pail

### Main features

- Public page with a player and song request support
- Private panel with authentication
- Dashboard with activities and task completion
- Management for posts, reviews, events, podcasts, media, and marketing assets
- Radio management for programs, music rankings, listener of the month, and song requests
- Live hosting flow for starting and finishing broadcasts
- Administration area for users, roles, permissions, calendars, activities, tasks, and automatic programs
- Profile management
- Cast endpoints for stream redirects and metadata
- Discord webhook integration for stream events

### Requirements

- PHP 8.2+
- Composer
- Node.js and npm
- MySQL
- Redis is optional, depending on your local cache/session configuration

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

To prepare the database with initial data, run the seeders:

```bash
php artisan db:seed
```

For a fresh local environment, you can recreate the database and seed it in one command:

```bash
php artisan migrate:fresh --seed
```

The seeders create permissions, roles, users, activities, programs, content, podcasts, radio data, polls, song requests, and other development records. The local administrator user created by the seeder is:

```text
Username: admin
Password: admin
```

### Development

Run the full local development stack through the Composer script:

```bash
php artisan dev
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
php artisan test
```

### Useful routes

- `/` - provisional public home/player
- `/site` - public site route
- `/panel` - panel login
- `/panel/dashboard` - private dashboard
- `/panel/radio` - radio management
- `/panel/locution` - live hosting area
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
- `app/Console/Commands` - custom Artisan commands
- `app/Http/Controllers` - public, private, API, and provisional controllers
- `app/Http/Requests` - form request validation
- `app/Http/Resources` - API/resource response formatting
- `app/Models` - Eloquent models
- `app/Policies` - authorization rules
- `app/Services` - external and processing services
- `database/seeders` - initial data and development records
- `resources/js/pages` - Inertia/Svelte pages
- `resources/js/ui` - reusable UI components, layouts, and widgets
- `routes/web` - web routes split by context

### License

This project is open-sourced under the MIT license.
