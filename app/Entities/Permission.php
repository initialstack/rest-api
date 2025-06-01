<?php declare(strict_types=1);

namespace App\Entities;

use App\Shared\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use App\Enums\Guard;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'permissions')]
final class Permission extends Entity
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface $id;

    /**
     * The name of the permission.
     *
     * @var string
     */
    #[Assert\NotBlank(message: 'Name must not be empty.')]
    #[Assert\Length(
        min: 2,
        max: 64,
        minMessage: 'The permission name must be at least {{ limit }} characters long.',
        maxMessage: 'The permission name cannot be longer than {{ limit }} characters.'
    )]
    #[ORM\Column(name: 'name', type: Types::STRING, length: 64)]
    private string $name;

    /**
     * The guard associated with the permission.
     *
     * @var Guard
     */
    #[Assert\NotBlank(message: 'Guard must not be empty.')]
    #[ORM\Column(name: 'guard', type: Types::ENUM, enumType: Guard::class)]
    private Guard $guard;

    /**
     * The unique slug of the permission.
     *
     * @var string
     */
    #[Assert\NotBlank(message: 'Slug must not be empty.')]
    #[Assert\Length(
        min: 2,
        max: 64,
        minMessage: 'The slug must be at least {{ limit }} characters long.',
        maxMessage: 'The slug cannot be longer than {{ limit }} characters.'
    )]
    #[ORM\Column(name: 'slug', type: Types::STRING, length: 64, unique: true)]
    private string $slug;

    /**
     * The roles associated with this permission.
     *
     * @var Collection<int, Role>
     */
    #[ORM\ManyToMany(targetEntity: Role::class, mappedBy: 'permissions', fetch: 'EAGER')]
    private Collection $roles;

    /**
     * Initializes a new permission with the given details.
     *
     * @param string $name
     * @param Guard $guard
     * @param string $slug
     */
    public function __construct(string $name, Guard $guard, string $slug)
    {
        /**
         * Generates a new permission ID.
         */
        $this->id = Uuid::uuid4();

        /**
         * Sets the permission's name, guard, and slug.
         */
        $this->name = $name;
        $this->guard = $guard;
        $this->slug = $slug;

        /**
         * Initializes parent timestamps.
         */
        parent::__construct();

        /**
         * Initializes an empty collection for roles.
         */
        $this->roles = new ArrayCollection();
    }

    /**
     * Get the ID of the permission.
     *
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * Set the name of the permission.
     *
     * @param string $name The name of the permission.
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get the name of the permission.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the guard of the permission.
     *
     * @param Guard $guard The guard of the permission.
     */
    public function setGuard(Guard $guard): void
    {
        $this->guard = $guard;
    }

    /**
     * Get the guard of the permission.
     *
     * @return string
     */
    public function getGuard(): string
    {
        return $this->guard->value;
    }

    /**
     * Set the slug of the permission.
     *
     * @param string $slug The unique slug of the permission.
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * Get the slug of the permission.
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Add a role to the permission.
     *
     * @param Role $role The role to add.
     */
    public function addRoles(Role $role): void
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
            if (!$role->getPermissions()->contains($this)) {
                $role->addPermissions(permission: $this);
            }
        }
    }

    /**
     * Remove a role from the permission.
     *
     * @param Role $role The role to remove.
     */
    public function removeRoles(Role $role): void
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
            if ($role->getPermissions()->contains($this)) {
                $role->removePermissions(permission: $this);
            }
        }
    }
}
