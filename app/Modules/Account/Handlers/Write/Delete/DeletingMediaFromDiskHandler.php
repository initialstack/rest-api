<?php declare(strict_types=1);

namespace App\Modules\Account\Handlers\Write\Delete;

use App\Shared\Handler;
use App\Modules\Account\Commands\DeleteAccountCommand;
use App\Contracts\Interface\Repositories\MediaRepositoryInterface;
use Illuminate\Support\Facades\Storage;

final class DeletingMediaFromDiskHandler extends Handler
{
    public function __construct(
        private MediaRepositoryInterface $mediaRepository
    ) {}

    public function handle(
        DeleteAccountCommand $command, \Closure $next): mixed
    {
        $getMedia = $this->mediaRepository->findByEntityId(
            entityId: $command->id->toString()
        );

        if (is_array(value: $getMedia) && !empty($getMedia)) {
            foreach ($getMedia as $media) {
                $filePath = $media->getFilePath();

                if (Storage::exists(path: $filePath)) {
                    Storage::delete(paths: $filePath);
                }
            }
        }
        
        return $next($command);
    }
}
