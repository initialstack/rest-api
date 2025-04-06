<?php declare(strict_types=1);

namespace Tests\Feature\Migrations;

use Tests\Feature\FeatureTestCase;
use Illuminate\Support\Facades\Schema;

final class CreateRoleTableMigrationTest extends FeatureTestCase
{
    /**
     * Array containing expected columns and their allowed data types.
     *
     * @var array<string, array<string>>
     */
    private array $columns = [
        'id' => ['uuid'],
        'name' => ['varchar', 'string'],
        'slug' => ['varchar', 'string'],
        'created_at' => ['datetime', 'timestamp'],
        'updated_at' => ['datetime', 'timestamp']
    ];

    /**
     * Tests that the "roles" table is created and contains all required columns with correct data types.
     */
    public function test_roles_table_is_created_by_migration(): void
    {
        $this->assertTrue(
            condition: Schema::hasTable(table: 'roles'),
            message: 'Table "roles" does not exist'
        );

        $this->assertTrue(
            condition: Schema::hasColumns(
                table: 'roles',
                columns: [
                    'id',
                    'name',
                    'slug',
                    'created_at',
                    'updated_at',
                ]
            ),
            message: 'Table "roles" does not have all required columns'
        );

        $this->assertColumnTypesAreCorrect();
    }

    /**
     * Asserts that the data types of the columns in the "roles" table match the expected values.
     */
    private function assertColumnTypesAreCorrect(): void
    {
        foreach ($this->columns as $column => $types) {
            $this->assertTrue(
                condition: Schema::hasColumn(table: 'roles', column: $column),
                message: "Column {$column} does not exist"
            );

            $this->assertContains(
                needle: Schema::getColumnType(table: 'roles', column: $column),
                haystack: $types,
                message: "Column {$column} has incorrect type"
            );
        }
    }
}
