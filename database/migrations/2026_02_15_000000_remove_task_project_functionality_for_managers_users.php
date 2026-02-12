<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove tasks assigned to users and created by managers
        DB::table('tasks')->whereIn('assigned_to', function($query) {
            $query->select('id')->from('users')->whereHas('roles', function($q) {
                $q->whereIn('name', ['user', 'manager']);
            });
        })->delete();

        DB::table('tasks')->whereIn('user_id', function($query) {
            $query->select('id')->from('users')->whereHas('roles', function($q) {
                $q->whereIn('name', ['user', 'manager']);
            });
        })->delete();

        // Remove project assignments for users and managers
        DB::table('project_users')->whereIn('user_id', function($query) {
            $query->select('id')->from('users')->whereHas('roles', function($q) {
                $q->whereIn('name', ['user', 'manager']);
            });
        })->delete();

        // Remove comments from tasks (since tasks are task-related)
        DB::table('comments')->whereIn('user_id', function($query) {
            $query->select('id')->from('users')->whereHas('roles', function($q) {
                $q->whereIn('name', ['user', 'manager']);
            });
        })->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration removes data, so reversal is not possible
        // You would need to restore from backup
    }
};