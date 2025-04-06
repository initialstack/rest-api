<?php declare(strict_types=1);

namespace App\Modules\Account\Queries;

use Ramsey\Uuid\{Uuid, UuidInterface};
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use App\Shared\Query;

final class GetUserByIdQuery extends Query
{
    /**
     * The user ID to query.
     *
     * @var string
     */
    private string $userId;

    /**
     * Constructs a new GetUserByIdQuery instance.
     *
     * @param string $userId
     */
    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Retrieves the user ID as a UUID object if valid.
     *
     * @return \Ramsey\Uuid\UuidInterface|null
     */
    public function getId(): ?UuidInterface
    {
        if (!is_string(value: $this->userId)) {
            return null;
        }

        try {
            return Uuid::fromString(uuid: $this->userId);
        }

        catch (InvalidUuidStringException $e) {
            return null;
        }
    }
}
