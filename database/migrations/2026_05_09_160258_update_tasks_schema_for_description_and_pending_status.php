<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('tasks', 'content')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->renameColumn('content', 'description');
            });
        }

        if (Schema::hasColumn('tasks', 'description')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->string('description')->change();
            });
        }

        Schema::table('tasks', function (Blueprint $table) {
            $table->enum('status', ['pending', 'in_review', 'completed'])
                ->default('pending')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->enum('status', ['in_progress', 'in_review', 'completed', 'late'])
                ->default('in_progress')
                ->change();
        });

        if (Schema::hasColumn('tasks', 'description')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->longText('description')->change();
            });

            Schema::table('tasks', function (Blueprint $table) {
                $table->renameColumn('description', 'content');
            });
        }
    }
};
