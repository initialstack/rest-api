<?php declare(strict_types=1);

namespace Tests\Feature\Migrations;

use Tests\Feature\FeatureTestCase;
use Illuminate\Support\Facades\Schema;

final class CreateMediaTableMigrationTest extends FeatureTestCase
{
    /**
     * Array containing expected columns and their allowed data types.
     *
     * @var array<string, array<string>>
     */
    private array $columns = [
        'id' => ['uuid'],
        'entity_id' => ['uuid'],
        'entity_type' => ['varchar', 'string'],
        'file_path' => ['varchar', 'string'],
        'created_at' => ['datetime', 'timestamp'],
        'updated_at' => ['datetime', 'timestamp'],
    ];

    /**
     * Tests that the "media" table is created and contains all required columns.
     */
    public function test_media_table_is_created_by_migration(): void
    {
        $this->assertTrue(
            condition: Schema::hasTable(table: 'media'),
            message: 'Table "media" does not exist'
        );

        $this->assertTrue(
            condition: Schema::hasColumns(
                table: 'media',
                columns: [
                    'id',
                    'entity_id',
                    'entity_type',
                    'file_path',
                    'created_at',
                    'updated_at',
                ]
            ),
            message: 'Table "media" does not have all required columns'
        );

        $this->assertColumnTypesAreCorrect();
    }
    
    /**
     * Asserts that the data types of the columns in the "media" table match the expected values.
     */
    private function assertColumnTypesAreCorrect(): void
    {
        foreach ($this->columns as $column => $types) {
            $this->assertTrue(
                condition: Schema::hasColumn(table: 'media', column: $column),
                message: "Column {$column} does not exist"
            );

            $actualType = Schema::getColumnType(table: 'media', column: $column);
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
