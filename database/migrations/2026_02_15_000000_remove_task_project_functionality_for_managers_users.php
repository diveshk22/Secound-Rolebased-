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
        // Remove tasks assigned to users and created
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