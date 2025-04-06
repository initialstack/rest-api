<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Account\Processes\CreateAccountProcess;
use App\Modules\Account\Handlers\Write\Create\CreatingUserHandler;
use App\Modules\Account\Handlers\Write\Create\AssigningRoleHandler;
use App\Modules\Account\Handlers\Write\Create\UploadingAvatarHandler;
use App\Modules\Account\Handlers\Write\Create\SavingAvatarHandler;
use App\Modules\Account\Processes\UpdateAccountProcess;
use App\Modules\Account\Handlers\Write\Update\UpdatingUserHandler;
use App\Modules\Account\Handlers\Write\Update\UpdatingRoleHandler;
use App\Modules\Account\Handlers\Write\Update\UpdatingAvatarOnDiskHandler;
use App\Modules\Account\Handlers\Write\Update\UpdatingAvatarInDbHandler;
use App\Modules\Account\Processes\DeleteAccountProcess;
use App\Modules\Account\Handlers\Write\Delete\DeletingUserHandler;
use App\Modules\Account\Handlers\Write\Delete\DeletingMediaFromDiskHandler;
use App\Modules\Account\Handlers\Write\Delete\DeletingMediaFromDbHandler;
use App\Contracts\Interface\Buses\ProcessBusInterface;
use App\Services\Application;

final class ProcessServiceProvider extends ServiceProvider
{
    /**
     * Mapping of queries to their handlers.
     * 
     * @var array
     */
    private array $account = [
        CreateAccountProcess::class => [
            CreatingUserHandler::class,
            AssigningRoleHandler::class,
            UploadingAvatarHandler::class,
            SavingAvatarHandler::class,
        ],
        UpdateAccountProcess::class => [
            UpdatingUserHandler::class,
            UpdatingRoleHandler::class,
            UpdatingAvatarOnDiskHandler::class,
            UpdatingAvatarInDbHandler::class,
        ],
        DeleteAccountProcess::class => [
            DeletingUserHandler::class,
            DeletingMediaFromDiskHandler::class,
            DeletingMediaFromDatabaseHandler::class,
        ],
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(ProcessBusInterface $processBus): void
    {
        foreach ($this->account as $process => $tasks) {
            $processBus->register(map: [$process => $tasks]);
        }
    }
}
