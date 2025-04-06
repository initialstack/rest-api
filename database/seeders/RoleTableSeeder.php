<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Doctrine\ORM\EntityManagerInterface;
use App\Entities\Role;

final class RoleTableSeeder extends Seeder
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin' => 'Администратор',
            'user' => 'Пользователь',
        ];

        foreach ($roles as $slug => $name) {
            $this->entityManager->persist(
                object: new Role(
                    name: $name,
                    slug: $slug,
                )
            );

            $this->entityManager->flush();
        }
    }
}