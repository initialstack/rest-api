<?php declare(strict_types=1);

namespace App\Modules\Account\Processes;

use App\Shared\Process;
use App\Modules\Account\Handlers\Write\Update\UpdatingUserHandler;
use App\Modules\Account\Handlers\Write\Update\UpdatingRoleHandler;
use App\Modules\Account\Handlers\Write\Update\UpdatingAvatarOnDiskHandler;
use App\Modules\Account\Handlers\Write\Update\UpdatingAvatarInDbHandler;
use App\Modules\Account\Commands\UpdateAccountCommand;
use App\Shared\{Command, Request};

final class UpdateAccountProcess extends Process
{
    protected array $tasks = [
        UpdatingUserHandler::class,
        UpdatingRoleHandler::class,
        UpdatingAvatarOnDiskHandler::class,
        UpdatingAvatarInDbHandler::class,
    ];

    protected Command $command;

    public function __construct(
        protected Request $request
    ) {
        $this->command = new UpdateAccountCommand();

        parent::__construct(
            request: $this->request,
            command: $this->command
        );
    }
    
    public function __invoke(): mixed
    {
        return $this->run();
    }
}
