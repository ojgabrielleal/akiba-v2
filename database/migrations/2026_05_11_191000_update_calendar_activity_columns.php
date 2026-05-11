<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Calendar;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('calendar', function (Blueprint $table) {
            $table->enum('type', ['show', 'live', 'video', 'podcast', 'activity'])->nullable()->change();
        });

        Calendar::whereNotNull('activity_id')->update([
            'type' => null,
        ]);

        Schema::table('calendar', function (Blueprint $table) {
            $table->enum('type', ['show', 'live', 'video', 'podcast'])->nullable()->change();

            if (Schema::hasColumn('calendar', 'has_activity')) {
                $table->dropColumn('has_activity');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calendar', function (Blueprint $table) {
            if (! Schema::hasColumn('calendar', 'has_activity')) {
                $table->boolean('has_activity')->default(false)->after('uuid');
            }

            $table->enum('type', ['show', 'live', 'video', 'podcast', 'activity'])->nullable()->change();
        });

        Calendar::whereNotNull('activity_id')->update([
            'has_activity' => true,
            'type' => 'activity',
        ]);

        Schema::table('calendar', function (Blueprint $table) {
            $table->enum('type', ['show', 'live', 'video', 'podcast', 'activity'])->nullable(false)->change();
        });
    }
};
