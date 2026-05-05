<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('tasks')
            ->where('is_completed', true)
            ->update(['status' => 'completed']);

        DB::table('tasks')
            ->where('is_completed', false)
            ->whereDate('dead_line', '<', today())
            ->update(['status' => 'late']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('tasks')
            ->where('status', 'completed')
            ->update(['is_completed' => true]);
    }
};
