<?php

namespace App\Tests\Functional\Controller;

use App\DataFixtures\AvatarFilmSessionFixtures;
use App\DataFixtures\HobbitFilmSessionFixtures;
use App\Domain\Booking\Repository\DoctrineFilmSessionRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class FilmSessionControllerTest extends WebTestCase
{
    protected AbstractDatabaseTool $databaseTool;

    /**
     * @throws \Exception
     */
    public function setUp(): void
    {
        $this->client = self::createClient();
        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->repository = self::getContainer()->get(DoctrineFilmSessionRepository::class);
    }

    public function testRequestResponseSuccessfulResult(): void
    {
        $this->databaseTool->loadFixtures([HobbitFilmSessionFixtures::class, AvatarFilmSessionFixtures::class], true);

        $crawler = $this->client->request('GET', 'film-sessions');

        $this->assertResponseIsSuccessful();
        $this->assertCount(2, $crawler->filter('h2'));
    }

    public function testNotBookTicketIfNoSeatsAvailable(): void
    {
        $this->databaseTool->loadFixtures([HobbitFilmSessionFixtures::class], true);

        $filmSession = $this->repository->findOneBy([]);

        $this->client->request('GET', 'film-sessions/' . $filmSession->getFilmSessionId());

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('p', 'Билетов не осталось');
    }
}
