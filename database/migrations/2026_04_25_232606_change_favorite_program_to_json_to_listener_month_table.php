<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('listener_month')
            ->whereNotNull('favorite_program')
            ->update([
                'favorite_program' => DB::raw("JSON_OBJECT('name', favorite_program)"),
            ]);

        Schema::table('listener_month', function (Blueprint $table) {
            $table->json('favorite_program')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('listener_month')
            ->whereNotNull('favorite_program')
            ->update([
                'favorite_program' => DB::raw("JSON_UNQUOTE(JSON_EXTRACT(favorite_program, '$.name'))"),
            ]);

        Schema::table('listener_month', function (Blueprint $table) {
            $table->string('favorite_program')->change();
        });
    }
};
