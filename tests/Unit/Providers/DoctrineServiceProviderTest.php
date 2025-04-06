<?php declare(strict_types=1);

namespace Tests\Unit\Providers;

use Illuminate\Foundation\Testing\TestCase;
use App\Providers\DoctrineServiceProvider;
use Doctrine\ORM\{EntityManagerInterface, EntityManager};
use Illuminate\Support\Facades\{Log, DB};

final class DoctrineServiceProviderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app = app();

        Log::shouldReceive('error')->zeroOrMoreTimes();
        DB::shouldReceive('connection->getPdo->exec')->zeroOrMoreTimes();
    }

    public function testRegisterEntityManager(): void
    {
        $provider = new DoctrineServiceProvider(app: $this->app);
        $provider->register();

        $entityManager = $this->app->make(
            abstract: EntityManagerInterface::class
        );

        $this->assertInstanceOf(
            expected: EntityManager::class,
            actual: $entityManager
        );
    }

    public function testBootMethod(): void
    {
        $provider = new DoctrineServiceProvider(app: $this->app);
        $provider->boot();

        DB::connection()->getPdo()->exec("SET NAMES 'UTF8'");
    }
}
