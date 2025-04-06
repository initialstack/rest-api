<?php declare(strict_types=1);

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Entities\User;

final class Authenticate implements UserProvider
{
    /**
     * Handles database operations for user entities.
     * 
     * @var \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    private readonly EntityManagerInterface $entityManager;

    /**
     * Constructor to initialize the EntityManager.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier): ?Authenticatable
    {
        return $this->entityManager->find(
            className: User::class,
            id: $identifier
        );
    }

    /**
     * Retrieve a user by their token (not implemented).
     *
     * @param mixed $identifier
     * @param string $token
     * 
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token): ?Authenticatable
    {
        $user = $this->entityManager->getRepository(
            className: User::class
        )->findOneBy(
            criteria: [
                'remember_token' => $token,
                'id' => $identifier,
            ]
        );

        return $user;
    }

    /**
     * Update the "remember me" token (not implemented).
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string $token
     */
    public function updateRememberToken(Authenticatable $user, $token): void
    {
        $user->setRememberToken(value: $token);

        $this->entityManager->persist(object: $user);
        $this->entityManager->flush();
    }

    /**
     * Retrieve a user by their credentials (e.g., email).
     *
     * @param array $credentials
     * @return \App\Entities\User|null
     */
    public function retrieveByCredentials(array $credentials): ?User
    {
        $email = $credentials['email'];

        return $this->entityManager->getRepository(
            className: User::class
        )->findOneBy(
            criteria: ['email' => $email]
        );
    }

    /**
     * Validate user credentials (e.g., password).
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param array $credentials
     * 
     * @return bool
     */
    public function validateCredentials(
        Authenticatable $user, array $credentials): bool
    {
        $password = $credentials['password'];

        return Hash::check(value: $password,
            hashedValue: $user->getPassword()
        );
    }

    /**
     * Rehash the user's password if required and persist changes to the database.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param array $credentials
     * @param bool $force Whether to force rehashing regardless of current state.
     */
    public function rehashPasswordIfRequired(
        Authenticatable $user, array $credentials, bool $force = false): void
    {
        if (Hash::needsRehash(hashedValue: $user->getPassword()) || $force) {
            $user->setPassword(
                password: Hash::make(value: credentials['password'])
            );

            $this->entityManager->persist(object: $user);
            $this->entityManager->flush();
        }
    }

    /**
     * Generates a JWT token for a given user.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @return string|null
     */
    public function generateToken(Authenticatable $user): ?string
    {
        return JWTAuth::fromUser(user: $user);
    }

    /**
     * Refreshes the authentication token for the current user.
     *
     * @return string|null The refreshed token or null if refresh fails.
     */
    public function refresh(): ?string
    {
        return auth()->refresh();
    }

    /**
     * Retrieves the currently authenticated user.
     *
     * @return \App\Entities\User|null
     */
    public function getMe(): ?User
    {
        return auth()->user();
    }

    /**
     * Logs out the currently authenticated user.
     */
    public function logout(): void
    {
        auth()->logout();
    }
}
