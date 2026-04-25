<div align="center">
  <img src="https://i.imgur.com/WbKAm6A.png" alt="Akiba V2" width="500" />
</div>
<br/>

Idioma: [Português BR](README.md) | [English US](README.en-US.md)

Segunda versão (2026) do portal de notícias e web rádio da Rede Akiba, trazendo uma experiência renovada para fãs da cultura japonesa desde 2016.

## Sobre

Rede Akiba ( Akiba V2 ) é uma aplicação Laravel para gerenciar uma plataforma de comunidade e rádio focada em cultura anime. O projeto combina uma experiência pública de player com pedidos de músicas e um painel privado para conteúdo, programação, locução ao vivo, mídias, materiais de marketing, usuários, permissões e tarefas operacionais.

## Stack

- **Backend:** PHP 8.2, Laravel 12, Laravel Sanctum
- **Frontend:** Inertia.js, Svelte, Vite, Tailwind CSS 4
- **Banco de dados:** MySQL
- **Assets e mídia:** Intervention Image
- **Ferramentas:** PHPUnit, Laravel Pint, Laravel Pail

## Principais Recursos

- Página pública com player e suporte a pedidos de músicas
- Painel privado com autenticação
- Dashboard com atividades e conclusão de tarefas
- Gerenciamento de posts, reviews, eventos, podcasts, mídias e materiais de marketing
- Gerenciamento da rádio para programas, rankings de músicas, ouvinte do mês e pedidos de músicas
- Fluxo de locução ao vivo para iniciar e finalizar transmissões
- Área de administração para usuários, funções, permissões, calendários, atividades, tarefas e programas automáticos
- Gerenciamento de perfil
- Endpoints de cast para redirecionamento de stream e metadados
- Integração com webhook do Discord para eventos da stream

## Requisitos

- PHP 8.2+
- Composer
- Node.js e npm
- MySQL
- Redis é opcional, dependendo da configuração local de cache/sessão

## Instalação

Clone o repositório e instale as dependências PHP e JavaScript:

```bash
composer install
npm install
```

Crie o arquivo de ambiente e gere a chave da aplicação Laravel:

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

Para preparar o banco com dados iniciais, execute os seeders:

```bash
php artisan db:seed
```

Para um ambiente local novo, você pode recriar o banco e popular os dados em um único comando:

```bash
php artisan migrate:fresh --seed
```

Os seeders criam permissões, funções, usuários, atividades, programas, conteúdos, podcasts, dados da rádio, enquetes, pedidos de músicas e outros registros de desenvolvimento. O usuário administrador local criado pelo seeder é:

```text
Username: admin
Password: admin
```

## Desenvolvimento

Execute toda a stack local de desenvolvimento pelo comando Artisan customizado:

```bash
php artisan dev
```

Esse comando inicia o servidor Laravel, o listener de filas, os logs do Laravel Pail e o servidor de desenvolvimento do Vite juntos.

Você também pode executar cada serviço separadamente:

```bash
php artisan serve
npm run dev
php artisan queue:listen
```

## Build

Crie o build de frontend para produção:

```bash
npm run build
```

## Testes

Execute a suíte de testes:

```bash
php artisan test
```

## Rotas Úteis

- `/` - home/player público provisória
- `/site` - rota pública do site
- `/panel` - panel login
- `/panel/dashboard` - dashboard privado
- `/panel/radio` - gerenciamento da rádio
- `/panel/locution` - área de locução ao vivo
- `/panel/administration` - área de administração
- `/api/cast` - redirecionamento da stream do cast
- `/api/cast/metadata` - metadados do cast

## Notas de Ambiente

O projeto inclui variáveis de ambiente extras para integrações com stream e Discord:

```env
CAST_URL=null
CAST_METADATA=null
DISCORD_STREAM_WEBHOOK=null
```

Defina esses valores quando quiser conectar o app local a metadados reais da stream ou notificações por webhook.

## Estrutura do Projeto

- `app/Actions` - casos de uso da aplicação agrupados por domínio
- `app/Console/Commands` - comandos Artisan customizados
- `app/Http/Controllers` - controllers públicos, privados, de API e provisórios
- `app/Http/Requests` - validação de formulários
- `app/Http/Resources` - formatação de respostas de API/resources
- `app/Models` - Eloquent models
- `app/Policies` - regras de autorização
- `app/Services` - serviços externos e de processamento
- `database/seeders` - dados iniciais e registros de desenvolvimento
- `resources/js/pages` - páginas Inertia/Svelte
- `resources/js/ui` - componentes de UI, layouts e widgets reutilizáveis
- `routes/web` - rotas web separadas por contexto

## Licença

Este projeto é open-source sob a licença MIT.
