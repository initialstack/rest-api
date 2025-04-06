<?php declare(strict_types=1);

namespace App\Modules\Account\Handlers\Write\Create;

use App\Shared\Handler;
use App\Contracts\Interface\Repositories\MediaRepositoryInterface;
use App\Contracts\Interface\Repositories\UserRepositoryInterface;
use App\Modules\Account\Commands\CreateAccountCommand;
use App\Entities\{Media, User};

final class SavingAvatarHandler extends Handler
{
    public function __construct(
        private MediaRepositoryInterface $mediaRepository,
        private UserRepositoryInterface $userRepository
    ) {}

    public function handle(
        CreateAccountCommand $command, \Closure $next): mixed
    {
        try {
            if (!empty($command->filePath)) {
                $user = $this->userRepository->findById(
                    id: $command->userId
                );

                $media = new Media(
                    entityType: User::class,
                    entityId: $command->userId->toString(),
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
