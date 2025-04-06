<?php declare(strict_types=1);

namespace App\Shared;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Carbon\CarbonImmutable;

#[ORM\MappedSuperclass]
#[ORM\HasLifecycleCallbacks]
abstract class Entity
{
    /**
     * Timestamp when was created.
     *
     * @var \DateTimeImmutable
     */
    #[Assert\NotNull(message: 'Created at must not be null.')]
    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    protected \DateTimeImmutable $createdAt;

    /**
     * Timestamp when was last updated.
     *
     * @var \DateTimeImmutable
     */
    #[Assert\NotNull(message: 'Updated at must not be null.')]
    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    protected \DateTimeImmutable $updatedAt;

    /**
     * Initializes the given details
     */
    protected function __construct()
    {
        /**
         * Sets the created-at and updated-at timestamps to the current time.
         */
        $this->createdAt = CarbonImmutable::now();
        $this->updatedAt = CarbonImmutable::now();
    }

    /**
     * Get the creation timestamp of the entity.
     *
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Get the last update timestamp of the entity.
     *
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Updates The Modification Timestamp Before Persistence.
     */
    #[ORM\PreUpdate]
    public function setUpdatedAtOnUpdate(): void
    {
        $this->updatedAt = CarbonImmutable::now();
    }
}
