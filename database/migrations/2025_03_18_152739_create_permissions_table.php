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
        Schema::create(table: 'permissions',
            callback: function (Blueprint $table): void {
                $table->uuid(column: 'id')->primary();

                $table->string(column: 'name', length: 64);
                $table->string(column: 'slug', length: 64)->unique();
                $table->enum(
                    column: 'guard', allowed: [
                        'api',
                        'web'
                    ]
                );
                
                $table->timestamp(column: 'created_at', precision: 6);
                $table->timestamp(column: 'updated_at', precision: 6);
            }
        );

        Schema::table(table: 'permissions',
            callback: function (Blueprint $table): void {
                $table->comment(comment: 'Права');
                $table->index(columns: 'created_at');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'permissions');
    }
};
