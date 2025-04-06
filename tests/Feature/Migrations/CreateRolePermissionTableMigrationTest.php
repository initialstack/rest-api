<?php declare(strict_types=1);

namespace Tests\Feature\Migrations;

use Tests\Feature\FeatureTestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

final class CreateRolePermissionTableMigrationTest extends FeatureTestCase
{
    /**
     * Tests that the "role_permission" table is created and contains the required columns.
     */
    public function test_role_permission_table_is_created_by_migration(): void
    {
        $this->assertTrue(
            condition: Schema::hasTable(table: 'role_permission'),
            message: 'Table "role_permission" does not exist'
        );

        $this->assertTrue(
            condition: Schema::hasColumns(
                table: 'role_permission',
                columns: [
                    'role_id',
                    'permission_id',
                ]
            ),
            message: 'Table "role_permission" does not have all required columns'
        );

        $this->assertTrue(
            condition: Schema::hasColumn(table: 'role_permission', column: 'role_id'),
            message: 'Column "role_id" does not exist'
        );

        $this->assertTrue(
            condition: Schema::hasColumn(table: 'role_permission', column: 'permission_id'),
            message: 'Column "permission_id" does not exist'
        );

        $this->assertTrue(
            condition: $this->hasForeignKey('role_permission', 'role_id', 'roles', 'id'),
            message: 'Foreign key constraint on role_id does not exist'
        );

        $this->assertTrue(
            condition: $this->hasForeignKey('role_permission', 'permission_id', 'permissions', 'id'),
            message: 'Foreign key constraint on permission_id does not exist'
        );
    }

    /**
     * Checks if a foreign key constraint exists for the given table, column, and referenced table/column.
     *
     * @param string $table
     * @param string $column
     * @param string $referencesTable
     * @param string $referencesColumn
     * 
     * @return bool True if the foreign key exists, false otherwise.
     */
    private function hasForeignKey(
        string $table, string $column, string $referencesTable, string $referencesColumn): bool
    {
        $keyName = $table . '_' . $column . '_foreign';

        $exists = DB::table(
            table: 'information_schema.table_constraints'
        )->where(
            column: 'constraint_name',
            operator: '=',
            value: $keyName
        )->exists();

        return $exists;

        $result = \DB::selectOne(query: $sql);

        return $result->exists;
    }
}