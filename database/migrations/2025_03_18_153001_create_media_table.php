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
        Schema::create(table: 'media',
            callback: function (Blueprint $table): void {
                $table->uuid(column: 'id')->primary();

                $table->uuidMorphs(name: 'entity');
                $table->string(column: 'file_path', length: 255);
                
                $table->timestamp(column: 'created_at', precision: 6);
                $table->timestamp(column: 'updated_at', precision: 6);
            }
        );

        Schema::table(table: 'media',
            callback: function (Blueprint $table): void {
                $table->comment(comment: 'Медиафайлы');
                $table->index(columns: 'created_at');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'media');
    }
};
