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
        // MariaDB / MySQL: ENUM → JSON via temporary column to preserve data
        Schema::table('doctors', function (Blueprint $table) {
            $table->json('type_temp')->nullable()->after('reviews');
        });

        // Wrap existing single values into JSON arrays
        DB::statement("UPDATE doctors SET type_temp = JSON_ARRAY(`type`) WHERE `type` IS NOT NULL");

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->renameColumn('type_temp', 'type');
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->string('type_old')->default('consultant')->after('reviews');
        });

        // Extract first value from the JSON array
        DB::statement("UPDATE doctors SET type_old = JSON_UNQUOTE(JSON_EXTRACT(`type`, '$[0]'))");

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->renameColumn('type_old', 'type');
        });

        // Restore ENUM constraint
        DB::statement("ALTER TABLE doctors MODIFY COLUMN type ENUM('consultant', 'outdoor') DEFAULT 'consultant'");
    }
};
