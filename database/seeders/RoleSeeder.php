<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'administrator',
                'label' => 'Administrador',
                'description' => 'Tem acesso total ao sistema, podendo gerenciar usuários, permissões e configurações.',
                'weight' => 1000,
            ],
            [
                'name' => 'developer',
                'label' => 'Desenvolvedor',
                'description' => 'Responsável pela manutenção e implementação de novas funcionalidades no sistema.',
                'weight' => 900,
            ],
            [
                'name' => 'locutioner',
                'label' => 'Locutor',
                'description' => 'Gerencia transmissões ao vivo e interage com o público durante as programações.',
                'weight' => 800,
            ],
            [
                'name' => 'writer',
                'label' => 'Redator',
                'description' => 'Cria e edita artigos, notícias e demais conteúdos de texto para publicação.',
                'weight' => 700,
            ],
            [
                'name' => 'social_media',
                'label' => 'Social Media',
                'description' => 'Gerencia as redes sociais, produz postagens e acompanha o engajamento.',
                'weight' => 600,
            ],
            [
                'name' => 'marketing',
                'label' => 'Marketing',
                'description' => 'Responsável por campanhas, divulgação e estratégias de crescimento da marca.',
                'weight' => 500,
            ],
            [
                'name' => 'podcaster',
                'label' => 'Podcaster',
                'description' => 'Produz, edita e publica episódios de podcast na plataforma.',
                'weight' => 400,
            ],
        ];

        
        foreach($roles as $item){
            $role = Role::create([
                'name' => $item['name'],
                'label' => $item['label'],
                'description' => $item['description'],
                'weight' => $item['weight'],
            ]);

            // Assign permissions based on role name
            $this->assignPermissionsToRole($role);
        }
    }

    /**
     * Assign specific permissions to a role.
     */
    private function assignPermissionsToRole(Role $role): void
    {
        $permissions = [];

        $common = [
            'dashboard.view', 'warning.view', 'media.view'
        ];

        $activityTasks = [
            'activity.list', 'activity.view', 'activity.participate',
            'task.list', 'task.view', 'task.complete'
        ];

        $community = [
            'poll.list', 'poll.view', 'poll.create.vote'
        ];

        switch ($role->name) {
            case 'administrator':
            case 'developer':
                // All permissions
                $permissions = Permission::all()->pluck('name')->toArray();
                break;

            case 'locutioner':
                $permissions = array_merge($common, $activityTasks, $community, [
                    'locution.view', 'radio.view', 'locution.start', 'locution.finish',
                    'songrequest.list', 'songrequest.reproduce', 'songrequest.cancel', 'songrequest.toggle',
                    'program.list', 'program.view', 'music.list', 'music.update', 'music.set.ranking',
                    'listener.month.view', 'listener.month.set', 'user.view.own'
                ]);
                break;

            case 'writer':
                $permissions = array_merge($common, $activityTasks, $community, [
                    'post.view', 'post.list', 'post.create', 'post.update.own', 'post.list.own',
                    'review.list', 'review.view', 'review.create', 'review.update', 'user.view.own'
                ]);
                break;

            case 'social_media':
                $permissions = array_merge($common, $community, [
                    'marketing.view', 'post.list', 'post.view', 'post.create', 'post.update',
                    'event.list', 'event.view', 'event.create', 'event.update',
                    'poll.create', 'poll.update', 'poll.deactivate'
                ]);
                break;

            case 'marketing':
                $permissions = array_merge($common, [
                    'marketing.view', 'repository.list', 'repository.view', 'repository.create',
                    'repository.update', 'repository.deactivate', 'event.list', 'event.view',
                    'event.create', 'event.update'
                ]);
                break;

            case 'podcaster':
                $permissions = array_merge($common, [
                    'podcast.view', 'podcast.list', 'podcast.view', 'podcast.create',
                    'podcast.update', 'podcast.deactivate'
                ]);
                break;
        }

        if (!empty($permissions)) {
            $permissionIds = Permission::whereIn('name', $permissions)->pluck('id');
            $role->permissions()->attach($permissionIds);
        }
    }
}
