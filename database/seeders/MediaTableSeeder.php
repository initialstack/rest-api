<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Doctrine\ORM\EntityManagerInterface;
use App\Entities\{User, Media};
use Illuminate\Http\UploadedFile;

final class MediaTableSeeder extends Seeder
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
        $users = $this->entityManager->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            $media = new Media(
                entityType: User::class,
                entityId: $user->getId()->toString(),
                filePath: UploadedFile::fake()->image(
                    name: uniqid() . '.jpg',
                    width: 50,
                    height: 50
                )->store(
                    path: 'avatars/' . date(format: 'Y-m-d'),
                    options: []
                )
            );

            $media->setUser($user);
            $user->addMedia($media);

            $this->entityManager->persist($media);
        }
        
        $this->entityManager->flush();
    }
}
