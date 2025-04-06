<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Doctrine\ORM\EntityManagerInterface;
use App\Entities\{Permission, Role};
use App\Enums\Guard;

final class PermissionTableSeeder extends Seeder
{
    private array $actions = [
        // User Management
        'Create New Account' => 'create-account',
        'Verify Account Ownership' => 'verify-account',

        // Account Access
        'View Account Details' => 'view-account',
        'Access Account Dashboard' => 'access-dashboard',

        // Account Updates
        'Update Account Information' => 'update-account',
        'Change Account Password' => 'change-password',
        'Update Account Preferences' => 'update-preferences',

        // Account Security
        'Enable Two-Factor Authentication' => 'enable-2fa',
        'Manage Account Sessions' => 'manage-sessions',

        // Account Deactivation/Deletion
        'Deactivate Account' => 'deactivate-account',
        'Permanently Delete Account' => 'delete-account',

        // Account Roles and Permissions
        'Assign Account Roles' => 'assign-roles',
        'Manage Account Permissions' => 'manage-permissions',

        // Account Billing and Subscriptions
        'View Billing Information' => 'view-billing',
        'Update Payment Methods' => 'update-payment',
        'Manage Subscriptions' => 'manage-subscriptions',
    ];

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = $this->entityManager->getRepository(
            className: Role::class
        )->findOneBy(
            criteria: ['slug' => 'admin']
        );
        
        foreach ($this->actions as $name => $slug) {
            $permission = new Permission(
                name: $name,
                guard: Guard::API,
                slug: $slug,
            );

            $this->entityManager->persist(
                object: $permission
            );


            if (!$role) {
                throw new \RuntimeException(
                    message: 'Admin Role Not Found.'
                );
            }

            $role->addPermissions($permission);
        }

        $this->entityManager->flush();
    }
}
