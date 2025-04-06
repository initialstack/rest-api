<?php declare(strict_types=1);

namespace App\Modules\Account\Processes;

use App\Shared\Process;
use App\Modules\Account\Handlers\Write\Create\CreatingUserHandler;
use App\Modules\Account\Handlers\Write\Create\AssigningRoleHandler;
use App\Modules\Account\Handlers\Write\Create\UploadingAvatarHandler;
use App\Modules\Account\Handlers\Write\Create\SavingAvatarHandler;
use App\Modules\Account\Commands\CreateAccountCommand;
use App\Shared\{Command, Request};

final class CreateAccountProcess extends Process
{
    /**
     * Array of tasks that will be executed in the pipeline during user creation.
     *
     * @var callable[]
     */
    protected array $tasks = [
        CreatingUserHandler::class,
        AssigningRoleHandler::class,
        UploadingAvatarHandler::class,
        SavingAvatarHandler::class,
    ];

    /**
     * Command used to create the account.
     * 
     * @param \App\Shared\Command<\App\Modules\Account\Commands\CreateAccountCommand> $command
     */
    protected Command $command;

    /**
     * Initializes a new process for creating a user account.
     *
     * @param \App\Shared\Request<\App\Modules\Account\Requests\CreateAccountRequest> $request
     */
    public function __construct(
        protected Request $request
    ) {
        $this->command = new CreateAccountCommand();

        parent::__construct(
            request: $this->request,
            command: $this->command
        );
    }

    /**
     * Invokes the process.
     *
     * @return mixed
     */
    public function __invoke(): mixed
    {
        return $this->run();
    }
}
