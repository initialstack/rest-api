<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Doctrine\ORM\EntityManagerInterface;
use App\Entities\{User, Role};
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Generator;
use Carbon\Carbon;

final class UserTableSeeder extends Seeder
{
    private readonly EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = $this->entityManager->getRepository(
            className: Role::class
        )->findOneBy(
            criteria: ['slug' => 'admin']
        );

        if (empty($roles)) {
            throw new \RuntimeException(
                message: 'No roles found in the database.'
            );
        }

        for ($i = 0; $i < 10; $i++) {
            $user = new User(
                firstName: fake()->unique()->firstName(),
                lastName: fake()->unique()->lastName(),
                email: fake()->unique()->safeEmail(),
                password: Hash::make(value: '#Z1945-08z#'),
            );

            $user->setPatronymic(patronymic: fake()->firstNameMale());

            $user->setPhone(
                phone: sprintf(
                    '+7 (%d) %d-%d-%d',
                    rand(min: 100, max: 999),
                    rand(min: 100, max: 999),
                    rand(min: 10, max: 99),
                    rand(min: 10, max: 99)
                )
            );

            $user->setStatus(status: fake()->boolean());
            $user->setRole($roles);
            
            if (!$user->isEmailVerified()) {
                $user->markEmailAsVerified();
            }

            $this->entityManager->persist(object: $user);
        }

        $this->entityManager->flush();
    }
}