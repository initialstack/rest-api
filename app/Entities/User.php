<?php declare(strict_types=1);

namespace App\Entities;

use App\Shared\Entity;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use Carbon\Carbon;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User extends Entity implements JWTSubject, AuthenticatableContract
{
    use Authenticatable;

    /**
     * Unique identifier for the user.
     *
     * @var UuidInterface
     */
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface $id;

    /**
     * The user's first name.
     *
     * @var string
     */
    #[Assert\NotBlank(message: 'First name must not be empty.')]
    #[Assert\Length(
        min: 2,
        max: 18,
        minMessage: 'First name must be at least {{ limit }} characters long.',
        maxMessage: 'First name cannot be longer than {{ limit }} characters.'
    )]
    #[ORM\Column(name: 'first_name', type: Types::STRING, length: 18)]
    private string $firstName;

    /**
     * The user's last name.
     *
     * @var string
     */
    #[Assert\NotBlank(message: 'Last name must not be empty.')]
    #[Assert\Length(
        min: 2,
        max: 27,
        minMessage: 'Last name must be at least {{ limit }} characters long.',
        maxMessage: 'Last name cannot be longer than {{ limit }} characters.'
    )]
    #[ORM\Column(name: 'last_name', type: Types::STRING, length: 27)]
    private string $lastName;

    /**
     * The user's patronymic (middle name).
     *
     * @var string|null
     */
    #[Assert\Length(
        min: 2,
        max: 16,
        minMessage: 'Patronymic must be at least {{ limit }} characters long.',
        maxMessage: 'Patronymic cannot be longer than {{ limit }} characters.'
    )]
    #[ORM\Column(name: 'patronymic', type: Types::STRING, length: 16, nullable: true)]
    private ?string $patronymic = null;

    /**
     * The user's email address.
     *
     * @var string
     */
    #[Assert\NotBlank(message: 'Email must not be empty.')]
    #[Assert\Email(message: 'Email must be a valid email address.')]
    #[Assert\Length(max: 254, maxMessage: 'Email must be less than 254 characters.')]
    #[ORM\Column(name: 'email', type: Types::STRING, length: 254, unique: true)]
    private string $email;

    /**
     * The timestamp when the email was verified.
     *
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'email_verified_at', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $emailVerifiedAt = null;

    /**
     * The user's phone number.
     *
     * @var string|null
     */
    #[Assert\Length(
        min: 11,
        max: 20,
        minMessage: 'Phone number must be at least {{ limit }} characters long.',
        maxMessage: 'Phone number cannot be longer than {{ limit }} characters.'
    )]
    #[ORM\Column(name: 'phone', type: Types::STRING, length: 20, unique: true, nullable: true)]
    private ?string $phone = null;

    /**
     * The token used for "remember me" functionality.
     *
     * @var string|null
     */
    #[ORM\Column(name: 'remember_token', type: Types::STRING, length: 100, unique: true, nullable: true)]
    private ?string $rememberToken = null;

    /**
     * The user's password.
     *
     * @var string
     */
    #[Assert\NotBlank(message: 'Password must not be empty.')]
    #[Assert\Length(
        min: 8,
        max: 60,
        minMessage: 'Password must be at least {{ limit }} characters long.',
        maxMessage: 'Password cannot be longer than {{ limit }} characters.'
    )]
    #[ORM\Column(name: 'password', type: Types::STRING, length: 60)]
    private string $password;

    /**
     * The user's status (active/inactive).
     *
     * @var bool
     */
    #[Assert\NotNull(message: 'Status must not be null.')]
    #[ORM\Column(name: 'status', type: Types::BOOLEAN)]
    private bool $status;

    /**
     * The role assigned to the user.
     *
     * @var Role|null
     */
    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: 'users', fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'role_id', referencedColumnName: 'id', nullable: true)]
    private ?Role $role;

    /**
     * Collection of media associated with the user.
     *
     * @var Collection<int, Media>
     */
    #[ORM\OneToMany(targetEntity: Media::class, mappedBy: 'user', cascade: ['persist', 'remove'], orphanRemoval: true, fetch: 'EAGER')]
    private Collection $media;

    /**
     * Initializes a new user with the given details.
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     */
    public function __construct(string $firstName, string $lastName, string $email, string $password)
    {
        /**
         * Generates a new user ID.
         */
        $this->id = Uuid::uuid4();

        /**
         * Sets the user's first name, last name, email, and password.
         */
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;

        /**
         * Sets the user's status to active.
         */
        $this->status = true;

        /**
         * Initializes parent timestamps.
         */
        parent::__construct();

        /**
         * Initializes an empty collection for media.
         */
        $this->media = new ArrayCollection();
    }

    /**
     * Get the unique identifier (UUID) of the entity.
     *
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * Set the first name of the entity.
     *
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * Get the first name of the entity.
     *
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Set the last name of the entity.
     *
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * Get the last name of the entity.
     *
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Set the patronymic (middle name) of the entity.
     *
     * @param string|null $patronymic
     */
    public function setPatronymic(?string $patronymic): void
    {
        $this->patronymic = $patronymic;
    }

    /**
     * Get the patronymic (middle name) of the entity.
     *
     * @return string|null
     */
    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    /**
     * Set the email address of the entity.
     *
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Get the email address of the entity.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Mark the email as verified by setting the verification timestamp to the current time.
     */
    public function markEmailAsVerified(): void
    {
        $this->emailVerifiedAt = Carbon::now();
    }

    /**
     * Check if the email has been verified.
     *
     * @return bool
     */
    public function isEmailVerified(): bool
    {
        return $this->emailVerifiedAt !== null;
    }

    /**
     * Get the timestamp when the email was verified.
     *
     * @return \DateTime|null
     */
    public function getEmailVerifiedAt(): ?\DateTime
    {
        return $this->emailVerifiedAt;
    }

    /**
     * Set the phone number of the entity.
     *
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * Get the phone number of the entity.
     *
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Set the password of the entity.
     *
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Get the password of the entity.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the status of the entity.
     *
     * @param bool $status
     */
    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    /**
     * Get the status of the entity.
     *
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * Set the role of the entity.
     *
     * @param Role|null $role
     */
    public function setRole(?Role $role): void
    {
        $this->role = $role;
    }

    /**
     * Get the role of the entity.
     *
     * @return Role|null
     */
    public function getRole(): ?Role
    {
        return $this->role;
    }

    /**
     * Add a media object to the entity.
     *
     * @param Media $media
     */
    public function addMedia(Media $media): void
    {
        if (!$this->media->contains($media)) {
            $this->media->add($media);

            $media->setEntityType(entityType: self::class);
            $media->setEntityId(
                entityId: $this->id->toString()
            );
        }
    }

    /**
     * Get the collection of media objects associated with the entity.
     *
     * @return Collection<int, Media>
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    /**
     * Remove a media object from the entity.
     *
     * @param Media $media
     */
    public function removeMedia(Media $media): void
    {
        if ($this->media->contains($media)) {
            $this->media->removeElement($media);
        }
    }

    /**
     * Get the identifier that will be stored in the JWT subject claim.
     *
     * @return string
     */
    public function getJWTIdentifier(): string
    {
        return $this->id->toString();
    }

    /**
     * Get the custom claims to be added to the JWT.
     *
     * @return array<string, mixed>
     */
    public function getJWTCustomClaims(): array
    {
        return [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
        ];
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifier(): string
    {
        return $this->getId()->toString();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword(): string
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken(): string
    {
        return $this->rememberToken ?? '';
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param string $value
     */
    public function setRememberToken($value): void
    {
        $this->rememberToken = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}
