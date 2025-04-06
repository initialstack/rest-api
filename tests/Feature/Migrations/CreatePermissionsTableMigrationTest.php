<?php declare(strict_types=1);

namespace Tests\Feature\Migrations;

use Tests\Feature\FeatureTestCase;
use Illuminate\Support\Facades\Schema;

final class CreatePermissionsTableMigrationTest extends FeatureTestCase
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
        'guard' => ['varchar', 'string'],
        'created_at' => ['datetime', 'timestamp'],
        'updated_at' => ['datetime', 'timestamp'],
    ];

    /**
     * Tests that the "permissions" table is created and contains all required columns.
     */
    public function test_permissions_table_is_created_by_migration(): void
    {
        $this->assertTrue(
            condition: Schema::hasTable(table: 'permissions'),
            message: 'Table "permissions" does not exist'
        );

        $this->assertTrue(
            condition: Schema::hasColumns(
                table: 'permissions',
                columns: [
                    'id',
                    'name',
                    'slug',
                    'guard',
                    'created_at',
                    'updated_at',
                ]
            ),
            message: 'Table "permissions" does not have all required columns'
        );

        $this->assertColumnTypesAreCorrect();
    }

    /**
     * Asserts that the data types of the columns in the "permissions" table match the expected values.
     */
    private function assertColumnTypesAreCorrect(): void
    {
        foreach ($this->columns as $column => $types) {
            $this->assertTrue(
                condition: Schema::hasColumn(table: 'permissions', column: $column),
                message: "Column {$column} does not exist"
            );

            $actualType = Schema::getColumnType(table: 'permissions', column: $column);

            if ($column === 'guard' && $actualType === 'string') {
                $this->assertTrue(condition: true);
            } else {
                $message = "Column {$column} has incorrect type. Expected: ";

                $this->assertContains(
                    needle: $actualType,
                    haystack: $types,
                    message: $message . implode(
                        separator: ', ',
                        array: $types
                    ) . ", Actual: " . $actualType
                );
            }
        }
    }
}