<?php declare(strict_types=1);

namespace Tests\Unit\Entities;

use Tests\Unit\UnitTestCase;
use App\Entities\{User, Role, Media};
use Ramsey\Uuid\{Uuid, UuidInterface};
use Carbon\Carbon;

final class UserTest extends UnitTestCase
{
    private User $user;

    protected function setUp(): void
    {
        $this->user = new User(
            firstName: 'Vladislav',
            lastName: 'Malikov',
            email: 'test@mail.ru',
            password: '#paSSword123#'
        );
    }

    public function testGetId(): void
    {
        $this->assertInstanceOf(
            expected: UuidInterface::class,
            actual: $this->user->getId()
        );
    }

    public function testGetFirstName(): void
    {
        $this->assertEquals(
            expected: 'Vladislav',
            actual: $this->user->getFirstName()
        );
    }

    public function testSetFirstName(): void
    {
        $this->user->setFirstName(firstName: 'Test');

        $this->assertEquals(
            expected: 'Test',
            actual: $this->user->getFirstName()
        );
    }

    public function testGetLastName(): void
    {
        $this->assertEquals(
            expected: 'Malikov',
            actual: $this->user->getLastName()
        );
    }

    public function testSetLastName(): void
    {
        $this->user->setLastName(lastName: 'Test');

        $this->assertEquals(
            expected: 'Test',
            actual: $this->user->getLastName()
        );
    }

    public function testGetPatronymic(): void
    {
        $this->assertNull(
            actual: $this->user->getPatronymic()
        );
    }

    public function testSetPatronymic(): void
    {
        $this->user->setPatronymic(patronymic: 'Test');

        $this->assertEquals(
            expected: 'Test',
            actual: $this->user->getPatronymic()
        );
    }

    public function testGetEmail(): void
    {
        $this->assertEquals(
            expected: 'test@mail.ru',
            actual: $this->user->getEmail()
        );
    }

    public function testSetEmail(): void
    {
        $this->user->setEmail(email: 'test@yandex.ru');

        $this->assertEquals(
            expected: 'test@yandex.ru',
            actual: $this->user->getEmail()
        );
    }

    public function testMarkEmailAsVerified(): void
    {
        $this->user->markEmailAsVerified();

        $this->assertNotNull(
            actual: $this->user->getEmailVerifiedAt()
        );

        $this->assertTrue(
            condition: $this->user->isEmailVerified()
        );
    }

    public function testGetPhone(): void
    {
        $this->assertNull(actual: $this->user->getPhone());
    }

    public function testSetPhone(): void
    {
        $this->user->setPhone(phone: '+ 7 (777) 777-77-77');

        $this->assertEquals(
            expected: '+ 7 (777) 777-77-77',
            actual: $this->user->getPhone()
        );
    }

    public function testGetPassword(): void
    {
        $this->assertEquals(
            expected: '#paSSword123#',
            actual: $this->user->getPassword()
        );
    }

    public function testSetPassword(): void
    {
        $this->user->setPassword(password: '#paSSworD77#');

        $this->assertEquals(
            expected: '#paSSworD77#',
            actual: $this->user->getPassword()
        );
    }

    public function testGetStatus(): void
    {
        $this->assertTrue(
            condition: $this->user->getStatus()
        );
    }

    public function testSetStatus(): void
    {
        $this->user->setStatus(status: false);

        $this->assertFalse(
            condition: $this->user->getStatus()
        );
    }

    public function testGetCreatedAt(): void
    {
        $this->assertInstanceOf(
            expected: \DateTimeImmutable::class,
            actual: $this->user->getCreatedAt()
        );
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertInstanceOf(
            expected: \DateTimeImmutable::class,
            actual: $this->user->getUpdatedAt()
        );
    }

    public function testSetRole(): void
    {
        $role = new Role(name: 'Admin', slug: 'admin');
        $this->user->setRole(role: $role);

        $this->assertEquals(
            expected: $role,
            actual: $this->user->getRole()
        );
    }

    public function testAddMedia(): void
    {
        $media = new Media(
            entityType: User::class,
            entityId: $this->user->getId()->toString(),
            filePath: 'image.png'
        );

        $this->user->addMedia(media: $media);

        $this->assertCount(
            expectedCount: 1,
            haystack: $this->user->getMedia()
        );
    }

    public function testRemoveMedia(): void
    {
        $media = new Media(
            entityType: User::class,
            entityId: $this->user->getId()->toString(),
            filePath: 'image.png'
        );

        $this->user->addMedia(media: $media);
        $this->user->removeMedia(media: $media);

        $this->assertCount(
            expectedCount: 0,
            haystack: $this->user->getMedia()
        );
    }

    public function testGetJWTIdentifier(): void
    {
        $this->assertEquals(
            expected: $this->user->getId()->toString(),
            actual: $this->user->getJWTIdentifier()
        );
    }

    public function testGetJWTCustomClaims(): void
    {
        $this->user->setPhone(phone: '+ 7 (777) 777-77-77');
        $role = new Role(name: 'Admin', slug: 'admin');
        $this->user->setRole(role: $role);

        $customClaims = $this->user->getJWTCustomClaims();

        $this->assertArrayHasKey(
            key: 'id',
            array: $customClaims
        );

        $this->assertArrayHasKey(
            key: 'phone',
            array: $customClaims
        );

        $this->assertArrayHasKey(
            key: 'email',
            array: $customClaims
        );

        $this->assertArrayHasKey(
            key: 'role',
            array: $customClaims
        );

        $this->assertEquals(
            expected: $this->user->getId(),
            actual: $customClaims['id']
        );

        $this->assertEquals(
            expected: '+ 7 (777) 777-77-77',
            actual: $customClaims['phone']
        );

        $this->assertEquals(
            expected: 'test@mail.ru',
            actual: $customClaims['email']
        );

        $this->assertEquals(
            expected: 'Admin',
            actual: $customClaims['role']
        );
    }

    public function testGetAuthIdentifierName(): void
    {
        $this->assertEquals(
            expected: 'id',
            actual: $this->user->getAuthIdentifierName()
        );
    }

    public function testGetAuthIdentifier(): void
    {
        $this->assertEquals(
            expected: $this->user->getId()->toString(),
            actual: $this->user->getAuthIdentifier()
        );
    }

    public function testGetAuthPassword(): void
    {
        $this->assertEquals(
            expected: '#paSSword123#',
            actual: $this->user->getAuthPassword()
        );
    }

    public function testGetAndSetRememberToken(): void
    {
        $this->user->setRememberToken(
            value: 'remember_token_value'
        );

        $this->assertEquals(
            expected: 'remember_token_value',
            actual: $this->user->getRememberToken()
        );
    }

    public function testGetRememberTokenName(): void
    {
        $this->assertEquals(
            expected: 'remember_token',
            actual: $this->user->getRememberTokenName()
        );
    }
}