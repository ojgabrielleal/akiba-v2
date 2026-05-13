<div align="center">
  <img src="https://i.imgur.com/WbKAm6A.png" alt="Akiba V2" width="500" />
</div>
<br/>

Language: [Português BR](README.md) | [English US](README.en-US.md)

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

- Docker
- Docker Compose

## Instalação

Clone o repositório e rode o script de instalação:

```bash
git clone <repository-url>
cd akiba-v2
./scripts/install.sh
```

O script prepara o ambiente Docker, cria o `.env` quando necessário, instala as dependências PHP e JavaScript, gera a chave da aplicação, executa as migrations e popula o banco com os seeders.

O usuário administrador local criado pelo seeder é:

```text
Username: admin
Password: admin
```

## Desenvolvimento

Inicie o projeto com:

```bash
./scripts/server.sh up
```

O script sobe os containers e inicia o Laravel e o Vite com as flags necessárias para acesso pelo host.

Links locais:

```text
Site:       http://localhost:8000
Painel:     http://localhost:8000/panel
phpMyAdmin: http://localhost:8080
```

Para parar o projeto:

```bash
./scripts/server.sh down
```

Para reiniciar:

```bash
./scripts/server.sh restart
```

## Scripts Úteis

Os scripts em `./scripts` evitam digitar `docker compose exec` manualmente:

```bash
./scripts/install.sh
./scripts/server.sh up
./scripts/server.sh down
./scripts/laravel.sh php artisan migrate
./scripts/laravel.sh php artisan test
./scripts/node.sh npm install
./scripts/node.sh npm run build
./scripts/composer.sh require vendor/package
./scripts/shell.sh
./scripts/shell.sh node
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

Depois da instalação, revise o arquivo `.env` para configurar as integrações da rádio. O projeto inclui variáveis de ambiente para URL do streaming, metadados da rádio e webhook do Discord:

```env
CAST_URL=null
CAST_METADATA=null
DISCORD_LOCUTION_WEBHOOK=null
```

Defina `CAST_URL` e `CAST_METADATA` para conectar o app ao streaming real da rádio e aos metadados exibidos pelo player. Defina `DISCORD_LOCUTION_WEBHOOK` para ativar o suporte a notificações via webhook do Discord quando um locutor entrar ao vivo.

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
