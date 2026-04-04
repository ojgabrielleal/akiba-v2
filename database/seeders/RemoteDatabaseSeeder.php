<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class RemoteDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Setting up remote database connection...');
        
        Config::set('database.connections.remote', [
            'driver' => 'mysql',
            'host' => '108.181.92.76',
            'port' => '3306',
            'database' => 'akiba_db',
            'username' => 'akiba_usr_dev',
            'password' => '45i6RHeD$539Bv6y',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
        ]);

        try {
            $remoteTablesRaw = DB::connection('remote')->select('SHOW TABLES');
            $remoteTables = [];
            foreach ($remoteTablesRaw as $row) {
                $remoteTables[] = array_values((array)$row)[0];
            }

            $localTablesRaw = DB::connection()->select('SHOW TABLES');
            $localTables = [];
            foreach ($localTablesRaw as $row) {
                $localTables[] = array_values((array)$row)[0];
            }
        } catch (\Exception $e) {
            $this->command->error('Failed to connect to remote database: ' . $e->getMessage());
            return;
        }

        $this->command->info("Found " . count($remoteTables) . " remote tables and " . count($localTables) . " local tables.");

        // Manual Mapping (remote => local)
        $mapping = [
            'playlists_battles' => 'playlist_battle',
            'program_schedule' => 'programs_schedules',
            'shows' => 'programs',
            'users_externals_links' => 'users_socials',
            'listeners_requests' => 'songs_requests',
            'autodj' => 'automatic',
            'users_permissions' => 'permissions',
        ];

        // Specific Column Mapping (local_table => [remote_col => local_col])
        $columnMapping = [
            'musics' => [
                'music' => 'name',
                'listener_request_total' => 'song_requests_total',
                'is_ranking' => 'in_ranking',
            ],
            'songs_requests' => [
                'listener' => 'name',
                'listener_ip' => 'ip',
                'status' => 'was_reproduced', // Simplified
            ],
            'tasks' => [
                'completed' => 'is_completed',
                'deadline' => 'dead_line',
            ],
            'programs_schedules' => [
                'time' => 'hour',
            ],
            'onair' => [
                'is_live' => 'in_air',
                'image' => 'icon',
                'category' => 'type',
                'listener_request_total' => 'song_requests_total',
                'listener_request_status' => 'allows_song_requests',
            ],
            'listener_month' => [
                'listener' => 'name',
                'image' => 'avatar',
                'favorite_show' => 'favorite_program',
            ],
            'posts' => [
                // 'status' doesn't map directly to 'type' easily? Let's check.
                // Status in remote posts is likely 'active'/'inactive'.
                // Type in local posts is likely 'post'/'news'.
            ],
            'repositories' => [
                'file' => 'url',
                'category' => 'type',
            ],
            'automatic' => [
                // Specialized mapping below
            ]
        ];

        Schema::disableForeignKeyConstraints();

        foreach ($remoteTables as $remoteTable) {
            // Meta-tables skip
            if (in_array($remoteTable, ['migrations', 'failed_jobs', 'job_batches', 'jobs', 'sessions', 'cache', 'cache_locks', 'personal_access_tokens', 'autodj_phrases'])) continue;

            $localTable = $mapping[$remoteTable] ?? $remoteTable;
            
            if (in_array($localTable, $localTables)) {
                $this->command->info("Migrating {$remoteTable} to {$localTable}...");
                
                try {
                    $localColumns = Schema::getColumnListing($localTable);
                    $remoteData = DB::connection('remote')->table($remoteTable)->cursor();
                    
                    $colMap = $columnMapping[$localTable] ?? [];
                    $insertData = [];
                    $totalMigrated = 0;

                    foreach ($remoteData as $row) {
                        $item = (array) $row;
                        $filteredItem = [];

                        // Automatic Phrases Merge
                        if ($localTable === 'automatic') {
                            $phrases = DB::connection('remote')->table('autodj_phrases')->where('autodj_id', $item['id'])->get(['image', 'phrase'])->toArray();
                            $filteredItem['phrases'] = json_encode($phrases);
                        }

                        // Map columns
                        foreach ($localColumns as $col) {
                            if ($col === 'uuid') {
                                $filteredItem['uuid'] = (string) Str::uuid();
                                continue;
                            }

                            // Check mapping
                            $remoteCol = array_search($col, $colMap) ?: $col;
                            
                            if (array_key_exists($remoteCol, $item)) {
                                $val = $item[$remoteCol];
                                
                                // Specific value conversions
                                if ($col === 'was_reproduced' && $localTable === 'songs_requests') {
                                    $val = ($val === 'reproduced' || $val == 1) ? 1 : 0;
                                }
                                if ($col === 'in_ranking' && $localTable === 'musics') {
                                    $val = ($val == 'yes' || $val == 1) ? 1 : 0;
                                }
                                if ($col === 'is_completed' && $localTable === 'tasks') {
                                    $val = ($val == 'yes' || $val == 1) ? 1 : 0;
                                }
                                if ($col === 'allows_song_requests' && $localTable === 'onair') {
                                    $val = ($val == 'active' || $val == 1) ? 1 : 0;
                                }

                                $filteredItem[$col] = $val;
                            }
                        }

                        if (!empty($filteredItem)) {
                            $insertData[] = $filteredItem;
                        }

                        if (count($insertData) >= 500) {
                            DB::table($localTable)->insert($insertData);
                            $totalMigrated += count($insertData);
                            $insertData = [];
                        }
                    }

                    if (!empty($insertData)) {
                        DB::table($localTable)->insert($insertData);
                        $totalMigrated += count($insertData);
                    }
                    $this->command->info("Migrated " . $totalMigrated . " rows for {$localTable}.");
                } catch (\Exception $e) {
                    $this->command->error("Failed migrating {$remoteTable} to {$localTable}: " . $e->getMessage());
                }
            } else {
                $this->command->warn("Table {$localTable} (from {$remoteTable}) not found in local database. Skipping.");
            }
        }
        
        Schema::enableForeignKeyConstraints();

        $this->assignRemoteRoles();

        $this->command->info("Migration from remote database completed successfully!");
    }

    /**
     * Assign roles to specific remote users.
     */
    private function assignRemoteRoles(): void
    {
        $this->command->info('Assigning roles to remote users...');

        $roleMappings = [
            'administrator' => [1, 3],
            'developer' => [2],
            'podcaster' => [4],
            'locutioner' => [5, 6, 7, 8],
        ];

        foreach ($roleMappings as $roleName => $userIds) {
            $role = DB::table('roles')->where('name', $roleName)->first();
            
            if (!$role) {
                $this->command->warn("Role '{$roleName}' not found. Skipping assignment.");
                continue;
            }

            foreach ($userIds as $id) {
                // Check if user exists
                $user = DB::table('users')->where('id', $id)->first();
                if ($user) {
                    DB::table('roles_pivot')->updateOrInsert(
                        ['user_id' => $id, 'role_id' => $role->id],
                        ['user_id' => $id, 'role_id' => $role->id]
                    );
                }
            }
        }

        $this->command->info('Roles assigned successfully.');
    }
}
