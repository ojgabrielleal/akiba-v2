<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            /*
            |--------------------------------------------------------------------------
            | Accessos as páginas Gerais
            |--------------------------------------------------------------------------
            */
            ['name' => 'dashboard.view', 'label' => '[Dashboard] Visualizar página'],
            ['name' => 'warning.view', 'label' => '[Avisos] Visualizar página'],
            ['name' => 'post.view', 'label' => '[Matérias] Visualizar página'],
            ['name' => 'locution.view', 'label' => '[Locução] Visualizar página'],
            ['name' => 'radio.view', 'label' => '[Rádio] Visualizar página'],
            ['name' => 'podcast.view', 'label' => '[Podcasts] Visualizar página'],
            ['name' => 'marketing.view', 'label' => '[Marketing] Visualizar página'],
            ['name' => 'media.view', 'label' => '[Mídias] Visualizar página'],
            ['name' => 'administration.view', 'label' => '[Administração] Visualizar página'],
            ['name' => 'log.view', 'label' => '[Logs] Visualizar página'],

            /*
            |--------------------------------------------------------------------------
            | Atividades e avisos
            |--------------------------------------------------------------------------
            */
            ['name' => 'activity.list', 'label' => '[Atividades] Listar'],
            ['name' => 'activity.view', 'label' => '[Atividades] Visualizar'],
            ['name' => 'activity.create', 'label' => '[Atividades] Criar'],
            ['name' => 'activity.update', 'label' => '[Atividades] Atualizar'],
            ['name' => 'activity.deactivate', 'label' => '[Atividades] Desativar'],
            ['name' => 'activity.participate', 'label' => '[Atividades] Confirmar participação'],

            /*
            |--------------------------------------------------------------------------
            | Tarefas
            |--------------------------------------------------------------------------
            */
            ['name' => 'task.list', 'label' => '[Tarefas] Listar'],
            ['name' => 'task.view', 'label' => '[Tarefas] Visualizar'],
            ['name' => 'task.create', 'label' => '[Tarefas] Criar'],
            ['name' => 'task.update', 'label' => '[Tarefas] Atualizar'],
            ['name' => 'task.deactivate', 'label' => '[Tarefas] Desativar'],
            ['name' => 'task.complete', 'label' => '[Tarefas] Concluir'],

            /*
            |--------------------------------------------------------------------------
            | Calendário
            |--------------------------------------------------------------------------
            */
            ['name' => 'calendar.list', 'label' => '[Calendário] Listar'],
            ['name' => 'calendar.view', 'label' => '[Calendário] Visualizar'],
            ['name' => 'calendar.create', 'label' => '[Calendário] Criar'],
            ['name' => 'calendar.update', 'label' => '[Calendário] Atualizar'],
            ['name' => 'calendar.deactivate', 'label' => '[Calendário] Excluir'],

            /*
            |--------------------------------------------------------------------------
            | Posts
            |--------------------------------------------------------------------------
            */
            ['name' => 'post.list', 'label' => '[Matérias] Listar'],
            ['name' => 'post.view', 'label' => '[Matérias] Visualizar'],
            ['name' => 'post.create', 'label' => '[Matérias] Criar'],
            ['name' => 'post.update', 'label' => '[Matérias] Atualizar'],
            ['name' => 'post.deactivate', 'label' => '[Matérias] Desativar'],
            ['name' => 'post.list.own', 'label' => '[Matérias] Listar matérias próprias'],
            ['name' => 'post.update.own', 'label' => '[Matérias] Atualizar matérias próprias'],

            /*
            |--------------------------------------------------------------------------
            | Reviews
            |--------------------------------------------------------------------------
            */
            ['name' => 'review.list', 'label' => '[Reviews] Listar'],
            ['name' => 'review.view', 'label' => '[Reviews] Visualizar'],
            ['name' => 'review.create', 'label' => '[Reviews] Criar'],
            ['name' => 'review.update', 'label' => '[Reviews] Atualizar'],
            ['name' => 'review.deactivate', 'label' => '[Reviews] Desativar'],

            /*
            |--------------------------------------------------------------------------
            | Eventos
            |--------------------------------------------------------------------------
            */
            ['name' => 'event.list', 'label' => '[Eventos] Listar'],
            ['name' => 'event.view', 'label' => '[Eventos] Visualizar'],
            ['name' => 'event.create', 'label' => '[Eventos] Criar'],
            ['name' => 'event.update', 'label' => '[Eventos] Atualizar'],
            ['name' => 'event.deactivate', 'label' => '[Eventos] Desativar'],


            /*
            |--------------------------------------------------------------------------
            | Locução
            |--------------------------------------------------------------------------
            */
            ['name' => 'locution.start', 'label' => '[Locução] Iniciar programa'],
            ['name' => 'locution.finish', 'label' => '[Locução] Encerrar programa'],


            /*
            |--------------------------------------------------------------------------
            | Pedidos musicais
            |--------------------------------------------------------------------------
            */
            ['name' => 'songrequest.list', 'label' => '[Pedidos Música] Listar'],
            ['name' => 'songrequest.reproduce', 'label' => '[Pedidos Música] Atender'],
            ['name' => 'songrequest.cancel', 'label' => '[Pedidos Música] Cancelar'],
            ['name' => 'songrequest.toggle', 'label' => '[Pedidos Música] Ativar/Desativar '],

            /*
            |--------------------------------------------------------------------------
            | Programas
            |--------------------------------------------------------------------------
            */
            ['name' => 'program.list', 'label' => '[Programas] Listar'],
            ['name' => 'program.view', 'label' => '[Programas] Visualizar'],
            ['name' => 'program.create', 'label' => '[Programas] Criar'],
            ['name' => 'program.update', 'label' => '[Programas] Atualizar'],
            ['name' => 'program.deactivate', 'label' => '[Programas] Desativar'],

            /*
            |--------------------------------------------------------------------------
            | Músicas
            |--------------------------------------------------------------------------
            */
            ['name' => 'music.list', 'label' => '[Músicas] Listar'],
            ['name' => 'music.update', 'label' => '[Músicas] Atualizar'],
            ['name' => 'music.set.ranking', 'label' => '[Músicas] Definir ranking'],

            /*
            |--------------------------------------------------------------------------
            | Ouvinte do mês
            |--------------------------------------------------------------------------
            */
            ['name' => 'listener.month.view', 'label' => '[Ouvinte Mês] Visualizar'],
            ['name' => 'listener.month.set', 'label' => '[Ouvinte Mês] Definir ouvinte'],

            /*
            |--------------------------------------------------------------------------
            | Podcasts
            |--------------------------------------------------------------------------
            */
            ['name' => 'podcast.list', 'label' => '[Podcasts] Listar'],
            ['name' => 'podcast.view', 'label' => '[Podcasts] Visualizar'],
            ['name' => 'podcast.create', 'label' => '[Podcasts] Criar'],
            ['name' => 'podcast.update', 'label' => '[Podcasts] Atualizar'],
            ['name' => 'podcast.deactivate', 'label' => '[Podcasts] Desativar'],

            /*
            |--------------------------------------------------------------------------
            | Repository
            |--------------------------------------------------------------------------
            */
            ['name' => 'repository.list', 'label' => '[Marketing] Listar'],
            ['name' => 'repository.view', 'label' => '[Marketing] Visualizar'],
            ['name' => 'repository.create', 'label' => '[Marketing] Adicionar'],
            ['name' => 'repository.update', 'label' => '[Marketing] Atualizar'],
            ['name' => 'repository.deactivate', 'label' => '[Marketing] Desativar'],


            /*
            |--------------------------------------------------------------------------
            | Enquetes
            |--------------------------------------------------------------------------
            */
            ['name' => 'poll.list', 'label' => '[Enquetes] Listar'],
            ['name' => 'poll.view', 'label' => '[Enquetes] Visualizar'],
            ['name' => 'poll.create', 'label' => '[Enquetes] Criar'],
            ['name' => 'poll.update', 'label' => '[Enquetes] Atualizar'],
            ['name' => 'poll.deactivate', 'label' => '[Enquetes] Desativar'],
            ['name' => 'poll.create.vote', 'label' => '[Enquetes] Votar'],

            /*
            |--------------------------------------------------------------------------
            | Usuário
            |--------------------------------------------------------------------------
            */
            ['name' => 'user.list', 'label' => '[Usuários] Listar'],
            ['name' => 'user.view', 'label' => '[Usuários] Visualizar'],
            ['name' => 'user.create', 'label' => '[Usuários] Criar'],
            ['name' => 'user.update', 'label' => '[Usuários] Atualizar'],
            ['name' => 'user.deactivate', 'label' => '[Usuários] Desativar'],
            ['name' => 'user.view.own', 'label' => '[Usuários] Meu Perfil'],
            ['name' => 'user.update.authority', 'label' => '[Usuários] Atualizar Acessos/Cargos'],

            /*
            |--------------------------------------------------------------------------
            | Cargos e permissões
            |--------------------------------------------------------------------------
            */
            ['name' => 'role.list', 'label' => '[Cargos] Listar'],
            ['name' => 'role.view', 'label' => '[Cargos] Visualizar'],
            ['name' => 'role.create', 'label' => '[Cargos] Criar'],
            ['name' => 'role.update', 'label' => '[Cargos] Atualizar'],
            ['name' => 'role.deactivate', 'label' => '[Cargos] Desativar'],

        ];

        foreach ($permissions as $item) {
            Permission::updateOrCreate(
                ['name' => $item['name']],
                ['label' => $item['label']]
            );
        }

    }
}
