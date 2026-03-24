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
            ['name' => 'dashboard.view', 'label' => 'Visualizar página dashboard'],
            ['name' => 'warning.view', 'label' => 'Visualizar página avisos'],
            ['name' => 'post.view', 'label' => 'Visualizar página matérias'],
            ['name' => 'locution.view', 'label' => 'Visualizar página locução'],
            ['name' => 'radio.view', 'label' => 'Visualizar página rádio'],
            ['name' => 'podcast.view', 'label' => 'Visualizar página podcasts'],
            ['name' => 'marketing.view', 'label' => 'Visualizar página marketing'],
            ['name' => 'media.view', 'label' => 'Visualizar página mídias'],
            ['name' => 'administration.view', 'label' => 'Visualizar página administração'],
            ['name' => 'log.view', 'label' => 'Visualizar página logs'],
            
            /*
            |--------------------------------------------------------------------------
            | Atividades e avisos
            |--------------------------------------------------------------------------
            */
            ['name' => 'activity.list', 'label' => 'Listar atividades e avisos'],
            ['name' => 'activity.view', 'label' => 'Visualizar atividade e aviso'],
            ['name' => 'activity.create', 'label' => 'Criar atividades e avisos'],
            ['name' => 'activity.update', 'label' => 'Atualizar atividades e avisos'],
            ['name' => 'activity.deactivate', 'label' => 'Desativar atividades e avisos'],
            ['name' => 'activity.participate', 'label' => 'Confirmar participação em uma atividade'],

            /*
            |--------------------------------------------------------------------------
            | Tarefas
            |--------------------------------------------------------------------------
            */
            ['name' => 'task.list', 'label' => 'Listar tarefas'],
            ['name' => 'task.view', 'label' => 'Visualizar tarefa'],
            ['name' => 'task.create', 'label' => 'Criar tarefa'],
            ['name' => 'task.update', 'label' => 'Atualizar tarefa'],
            ['name' => 'task.deactivate', 'label' => 'Desativar tarefa'],
            ['name' => 'task.complete', 'label' => 'Confirmar tarefa como concluída'],

            /*
            |--------------------------------------------------------------------------
            | Calendário
            |--------------------------------------------------------------------------
            */
            ['name' => 'calendar.list', 'label' => 'Listar eventos no calendário'],
            ['name' => 'calendar.view', 'label' => 'Visualizar evento no calendário'],
            ['name' => 'calendar.create', 'label' => 'Criar evento no calendário'],
            ['name' => 'calendar.update', 'label' => 'Atualizar evento no calendário'],
            ['name' => 'calendar.deactivate', 'label' => 'Excluir evento no calendário'],

            /*
            |--------------------------------------------------------------------------
            | Posts
            |--------------------------------------------------------------------------
            */
            ['name' => 'post.list', 'label' => 'Listar posts'],
            ['name' => 'post.view', 'label' => 'Visualizar post'],
            ['name' => 'post.create', 'label' => 'Criar post'],
            ['name' => 'post.update', 'label' => 'Atualizar post'],
            ['name' => 'post.update.own', 'label' => 'Atualiza próprio post'],
            ['name' => 'post.deactivate', 'label' => 'Desativar post'],
            ['name' => 'post.list.own', 'label' => 'Listar próprios posts'],

            /*
            |--------------------------------------------------------------------------
            | Reviews
            |--------------------------------------------------------------------------
            */
            ['name' => 'review.list', 'label' => 'Listar reviews'],
            ['name' => 'review.view', 'label' => 'Visualizar review'],
            ['name' => 'review.create', 'label' => 'Criar review'],
            ['name' => 'review.update', 'label' => 'Atualizar review'],
            ['name' => 'review.deactivate', 'label' => 'Desativar review'],

            /*
            |--------------------------------------------------------------------------
            | Eventos
            |--------------------------------------------------------------------------
            */
            ['name' => 'event.list', 'label' => 'Listar eventos'],
            ['name' => 'event.view', 'label' => 'Visualizar evento'],
            ['name' => 'event.create', 'label' => 'Criar evento'],
            ['name' => 'event.update', 'label' => 'Atualizar evento'],
            ['name' => 'event.deactivate', 'label' => 'Desativar evento'],

            
            /*
            |--------------------------------------------------------------------------
            | Locução
            |--------------------------------------------------------------------------
            */
            ['name' => 'locution.start', 'label' => 'Iniciar programa'],
            ['name' => 'locution.finish', 'label' => 'Encerrar programa'],


            /*
            |--------------------------------------------------------------------------
            | Pedidos musicais
            |--------------------------------------------------------------------------
            */
            ['name' => 'songrequest.list', 'label' => 'Listas pedidos musicais'],
            ['name' => 'songrequest.reproduce', 'label' => 'Atender pedido musical'],
            ['name' => 'songrequest.cancel', 'label' => 'Cancelar pedido musical'],
            ['name' => 'songrequest.toggle', 'label' => 'Habilitar ou desabilitar pedidos musicais'],

            /*
            |--------------------------------------------------------------------------
            | Programas
            |--------------------------------------------------------------------------
            */
            ['name' => 'program.list', 'label' => 'Listar programas'],
            ['name' => 'program.view', 'label' => 'Visualizar programa'],
            ['name' => 'program.create', 'label' => 'Criar programa'],
            ['name' => 'program.update', 'label' => 'Atualizar programa'],
            ['name' => 'program.deactivate', 'label' => 'Desativar programa'],
            ['name' => 'program.schedule.create', 'label' => 'Criar horário para programa'],
            ['name' => 'program.schedule.update', 'label' => 'Atualizar horário para programa'],
            ['name' => 'program.schedule.remove', 'label' => 'Remover horário para programa'],

            /*
            |--------------------------------------------------------------------------
            | Músicas
            |--------------------------------------------------------------------------
            */
            ['name' => 'music.list', 'label' => 'Listar músicas'],
            ['name' => 'music.update', 'label' => 'Atualizar música'],
            ['name' => 'music.ranking.set', 'label' => 'Definir ranking de músicas'],
            /*
            |--------------------------------------------------------------------------
            | Ouvinte do mês
            |--------------------------------------------------------------------------
            */
            ['name' => 'listener.month.view', 'label' => 'Visualizar ouvinte do mês'],
            ['name' => 'listener.month.set', 'label' => 'Definir ouvinte do mês'],

            /*
            |--------------------------------------------------------------------------
            | Podcasts
            |--------------------------------------------------------------------------
            */
            ['name' => 'podcast.list', 'label' => 'Listar podcasts'],
            ['name' => 'podcast.view', 'label' => 'Visualizar podcast'],
            ['name' => 'podcast.create', 'label' => 'Criar podcast'],
            ['name' => 'podcast.update', 'label' => 'Atualizar podcast'],
            ['name' => 'podcast.deactivate', 'label' => 'Desativar podcast'],

            /*
            |--------------------------------------------------------------------------
            | Repository
            |--------------------------------------------------------------------------
            */
            ['name' => 'repository.list', 'label' => 'Listar arquivos no marketing'],
            ['name' => 'repository.view', 'label' => 'Visualizar arquivo no marketing'],
            ['name' => 'repository.create', 'label' => 'Criar um arquivo no marketing'],
            ['name' => 'repository.update', 'label' => 'Atualizar um arquivo no marketing'],
            ['name' => 'repository.deactivate', 'label' => 'Desativar um arquivo no marketing'],

            
            /*
            |--------------------------------------------------------------------------
            | Enquetes
            |--------------------------------------------------------------------------
            */
            ['name' => 'poll.list', 'label' => 'Listar enquetes'],
            ['name' => 'poll.view', 'label' => 'Visualizar enquete'],
            ['name' => 'poll.create', 'label' => 'Criar enquete'],
            ['name' => 'poll.create.vote', 'label' => 'Criar voto'],
            ['name' => 'poll.update', 'label' => 'Atualizar enquete'],
            ['name' => 'poll.deactivate', 'label' => 'Desativar enquete'],

            /*
            |--------------------------------------------------------------------------
            | Usuário
            |--------------------------------------------------------------------------
            */
            ['name' => 'user.list', 'label' => 'Listar usuários'],
            ['name' => 'user.view', 'label' => 'Visualizar usuário'],
            ['name' => 'user.create', 'label' => 'Criar usuário'],
            ['name' => 'user.update', 'label' => 'Atualizar usuário'],
            ['name' => 'user.deactivate', 'label' => 'Desativar usuário'],
            ['name' => 'user.view.own', 'label' => 'Visualizar o próprio usuário'],
            ['name' => 'user.update.own', 'label' => 'Atualizar o próprio usuário'],
            ['name' => 'user.access.update', 'label' => 'Atualizar dados de acesso e cargos do usuário']

        ];
        
        foreach($permissions as $item){
            Permission::create([
                'label' => $item['label'],
                'name' => $item['name']
            ]);
        }

    }
}
