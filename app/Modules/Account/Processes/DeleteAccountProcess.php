<?php declare(strict_types=1);

namespace App\Modules\Account\Processes;

use App\Shared\Process;
use App\Modules\Account\Handlers\Write\Delete\DeletingUserHandler;
use App\Modules\Account\Handlers\Write\Delete\DeletingMediaFromDiskHandler;
use App\Modules\Account\Handlers\Write\Delete\DeletingMediaFromDbHandler;
use App\Modules\Account\Commands\DeleteAccountCommand;
use App\Shared\{Command, Request};

final class DeleteAccountProcess extends Process
{
    protected array $tasks = [
        DeletingUserHandler::class,
        DeletingMediaFromDiskHandler::class,
        DeletingMediaFromDbHandler::class,
    ];

    protected Command $command;

    public function __construct(
        protected Request $request
    ) {
        $this->command = new DeleteAccountCommand();

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
