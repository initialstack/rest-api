<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(table: 'role_permission',
            callback: function (Blueprint $table): void {
                $table->foreignUuid(column: 'role_id')
                    ->constrained(table: 'roles')
                    ->noActionOnUpdate()
                    ->cascadeOnDelete();

                $table->foreignUuid(column: 'permission_id')
                    ->constrained(table: 'permissions')
                    ->noActionOnUpdate()
                    ->cascadeOnDelete();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'role_permission');
    }
};
