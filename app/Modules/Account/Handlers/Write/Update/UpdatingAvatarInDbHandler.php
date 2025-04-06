<?php declare(strict_types=1);

namespace App\Modules\Account\Handlers\Write\Update;

use App\Shared\Handler;
use App\Contracts\Interface\Repositories\MediaRepositoryInterface;
use App\Contracts\Interface\Repositories\UserRepositoryInterface;
use App\Modules\Account\Commands\UpdateAccountCommand;
use App\Entities\Media;

final class UpdatingAvatarInDbHandler extends Handler
{
    public function __construct(
        private MediaRepositoryInterface $mediaRepository,
        private UserRepositoryInterface $userRepository,
    ) {}

    public function handle(
        UpdateAccountCommand $command, \Closure $next): mixed
    {
        try {
            $getMedia = $this->mediaRepository->findByEntityId(
                entityId: $command->id->toString()
            );

            if (!empty($getMedia)) {
                $media = $this->mediaRepository->findById(
                    id: $getMedia[0]->getId()
                );

                if ($media && $command->filePath) {
                    $this->mediaRepository->remove(media: $media);
                }
            }

            if (is_string(value: $command->filePath)) {
                $user = $this->userRepository->findById(
                    id: $command->id
                );

                $media = new Media(
                    entityType: $user::class,
                    entityId: $user->getId()->toString(),
                    filePath: $command->filePath
                );

                $media->setUser(user: $user);

                $this->mediaRepository->save(media: $media);
            }

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
