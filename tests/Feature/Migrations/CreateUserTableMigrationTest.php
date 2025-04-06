<?php declare(strict_types=1);

namespace Tests\Feature\Migrations;

use Tests\Feature\FeatureTestCase;
use Illuminate\Support\Facades\Schema;

final class CreateUserTableMigrationTest extends FeatureTestCase
{
    /**
     * Array containing expected columns and their allowed data types.
     *
     * @var array<string, array<string>>
     */
    private array $columns = [
        'id' => ['uuid'],
        'first_name' => ['varchar', 'string'],
        'last_name' => ['varchar', 'string'],
        'patronymic' => ['varchar', 'string'],
        'phone' => ['varchar', 'string'],
        'email' => ['varchar', 'string'],
        'email_verified_at' => ['datetime', 'timestamp'],
        'password' => ['varchar', 'string'],
        'status' => ['bool', 'tinyint', 'boolean'],
        'role_id' => ['uuid'],
        'remember_token' => ['varchar', 'string'],
        'created_at' => ['datetime', 'timestamp'],
        'updated_at' => ['datetime', 'timestamp'],
    ];

    /**
     * Tests that the "users" table is created and contains all required columns with correct data types.
     */
    public function test_users_table_is_created_by_migration(): void
    {
        $this->assertTrue(
            condition: Schema::hasTable(table: 'users'),
            message: 'Table "users" does not exist'
        );

        $this->assertTrue(
            condition: Schema::hasColumns(
                table: 'users',
                columns: [
                    'id',
                    'first_name',
                    'last_name',
                    'patronymic',
                    'phone',
                    'email',
                    'email_verified_at',
                    'password',
                    'status',
                    'role_id',
                    'remember_token',
                    'created_at',
                    'updated_at',
                ]
            ),
            message: 'Table "users" does not have all required columns'
        );

        $this->assertColumnTypesAreCorrect();
    }

    /**
     * Asserts that the data types of the columns in the "users" table match the expected values.
     */
    private function assertColumnTypesAreCorrect(): void
    {
        foreach ($this->columns as $column => $types) {
            $this->assertTrue(
                condition: Schema::hasColumn(table: 'users', column: $column),
                message: "Column {$column} does not exist"
            );

            $this->assertContains(
                needle: Schema::getColumnType(table: 'users', column: $column),
                haystack: $types,
                message: "Column {$column} has incorrect type"
            );
        }
    }
}
