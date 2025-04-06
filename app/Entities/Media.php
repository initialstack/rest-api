<?php declare(strict_types=1);

namespace App\Entities;

use App\Shared\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'media')]
final class Media extends Entity
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface $id;

    /**
     * The type of the entity associated with the media.
     *
     * @var string
     */
    #[Assert\NotBlank(message: 'Entity type must not be empty.')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'The entity type cannot be longer than {{ limit }} characters.'
    )]
    #[ORM\Column(name: 'entity_type', type: Types::STRING)]
    private string $entityType;

    /**
     * The ID of the entity associated with the media.
     *
     * @var string
     */
    #[Assert\NotBlank(message: 'Entity ID must not be empty.')]
    #[ORM\Column(name: 'entity_id', type: Types::GUID)]
    private string $entityId;

    /**
     * The file path of the media.
     *
     * @var string
     */
    #[Assert\NotBlank(message: 'File path must not be empty.')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'The file path cannot be longer than {{ limit }} characters.'
    )]
    #[ORM\Column(name: 'file_path', type: Types::STRING, length: 255)]
    private string $filePath;

    /**
     * The user associated with the media.
     *
     * @var User
     */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'media')]
    #[ORM\JoinColumn(name: 'entity_id', referencedColumnName: 'id')]
    private User $user;

    /**
     * Initializes a new media with the given details.
     *
     * @param string $entityType
     * @param string $entityId
     * @param string $filePath
     */
    public function __construct(string $entityType, string $entityId, string $filePath)
    {
        /**
         * Generates a new media ID.
         */
        $this->id = Uuid::uuid4();

        /**
         * Sets the entity type, entity ID, and file path.
         */
        $this->entityType = $entityType;
        $this->entityId = $entityId;
        $this->filePath = $filePath;

        /**
         * Initializes parent timestamps.
         */
        parent::__construct();
    }

    /**
     * Get the ID of the media.
     *
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * Set the type of the entity associated with the media.
     *
     * @param string $entityType The type of the entity.
     */
    public function setEntityType(string $entityType): void
    {
        $this->entityType = $entityType;
    }

    /**
     * Get the type of the entity associated with the media.
     *
     * @return string
     */
    public function getEntityType(): string
    {
        return $this->entityType;
    }

    /**
     * Set the ID of the entity associated with the media.
     *
     * @param string $entityId The ID of the entity.
     */
    public function setEntityId(string $entityId): void
    {
        $this->entityId = $entityId;
    }

    /**
     * Get the ID of the entity associated with the media.
     *
     * @return string
     */
    public function getEntityId(): string
    {
        return $this->entityId;
    }

    /**
     * Set the file path of the media.
     *
     * @param string $filePath The file path of the media.
     */
    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }

    /**
     * Get the file path of the media.
     *
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * Set the user associated with the media.
     *
     * @param User $user The user to associate.
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
        $this->entityId = $user->getId()->toString();
    }

    /**
     * Get the user associated with the media.
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
