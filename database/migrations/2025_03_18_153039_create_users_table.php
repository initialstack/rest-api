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
        Schema::create(table: 'users',
            callback: function (Blueprint $table): void {
                $table->uuid('id')->primary();

                $table->string(column: 'first_name', length: 18);
                $table->string(column: 'last_name', length: 27);
                $table->string(column: 'patronymic', length: 16)->nullable();
                $table->string(column: 'phone', length: 20)->unique()->nullable();
                $table->string(column: 'email', length: 254)->unique();
                $table->timestamp(column: 'email_verified_at')->nullable();
                $table->string(column: 'password', length: 60);
                $table->boolean(column: 'status')->default(value: true);
                $table->foreignUuid(column: 'role_id')->nullable();

                $table->rememberToken();
                
                $table->timestamp(column: 'created_at', precision: 6);
                $table->timestamp(column: 'updated_at', precision: 6);
            }
        );

        Schema::table(table: 'users',
            callback: function (Blueprint $table): void {
                $table->comment(comment: 'Пользователи');

                $table->foreign(columns: 'role_id')
                    ->references(column: 'id')
                    ->on(table: 'roles')
                    ->restrictOnUpdate()
                    ->nullOnDelete();

                $table->index(columns: 'created_at');
            }
        );

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignUuid('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'users');
        Schema::dropIfExists(table: 'password_reset_tokens');
        Schema::dropIfExists(table: 'sessions');
    }
};
