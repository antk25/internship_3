<?php

namespace App\Tests\Functional;

use Doctrine\Common\DataFixtures\Executor\AbstractExecutor;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class FunctionalTestCase extends WebTestCase
{
    protected AbstractDatabaseTool $databaseTool;
    protected KernelBrowser $client;

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->client = self::createClient();
        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->databaseTool);
    }

    /**
     * @param array<string> $fixtures
     */
    public function loadFixtures(array $fixtures): AbstractExecutor
    {
        return $this->databaseTool->loadFixtures($fixtures);
    }
}
