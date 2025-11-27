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
        // No-op: two-factor columns are added by the previous migration
        // 2025_11_17_031148_add_two_factor_columns_to_users_table.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op: column removal is handled by the previous migration's down() method.
    }
};
