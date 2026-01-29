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
        // Check if user_id column exists, if not add it
        if (!Schema::hasColumn('tasks', 'user_id')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable();
            });
        }
        
        // Update existing tasks to assign them to the first user
        $firstUserId = \DB::table('users')->first()->id ?? null;
        if ($firstUserId) {
            \DB::table('tasks')->whereNull('user_id')->update(['user_id' => $firstUserId]);
        }
        
        // Add foreign key constraint if it doesn't exist
        $foreignKeys = \DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_NAME = 'tasks' AND COLUMN_NAME = 'user_id' AND CONSTRAINT_NAME != 'PRIMARY'");
        if (empty($foreignKeys)) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
