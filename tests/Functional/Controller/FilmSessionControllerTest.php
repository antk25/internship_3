<?php

namespace App\Tests\Functional\Controller;

use App\DataFixtures\AvatarFilmSessionWithFiveFreeSeatsFixtures;
use App\DataFixtures\HobbitFilmSessionWithNoFreeSeatsFixtures;
use App\Domain\Booking\Repository\DoctrineFilmSessionRepository;
use App\Tests\Functional\AbstractFunctionalTestCase;

final class FilmSessionControllerTest extends AbstractFunctionalTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->repository = self::getContainer()->get(DoctrineFilmSessionRepository::class);
    }

    public function testShowAvailableSessions(): void
    {
        $this->databaseTool->loadFixtures([
            HobbitFilmSessionWithNoFreeSeatsFixtures::class,
            AvatarFilmSessionWithFiveFreeSeatsFixtures::class,
        ]);

        $crawler = $this->client->request('GET', 'film-sessions');

        $this->assertResponseIsSuccessful();
        $this->assertCount($this->repository->count([]), $crawler->filter('h2'));
    }

    public function testBookTicketViaFormIfSuccessfulRedirectToFilmSessions(): void
    {
        $this->databaseTool->loadFixtures([AvatarFilmSessionWithFiveFreeSeatsFixtures::class]);

        $this->client->request('GET', 'film-sessions');

        $this->client->clickLink('Выбрать');

        $this->client->submitForm('Save', [
            'book_ticket[name]' => 'Федор',
            'book_ticket[phone]' => '89565263535',
        ]);
        $this->assertResponseRedirects();
        $this->client->followRedirect();

        $this->assertPageTitleContains('Список сеансов');
        $this->assertSelectorTextContains('p.number_of_seats', 'Кол-во свободных мест: 4');
    }

    public function testNotBookTicketIfNoSeatsAvailable(): void
    {
        $this->databaseTool->loadFixtures([HobbitFilmSessionWithNoFreeSeatsFixtures::class]);

        $this->client->request('GET', 'film-sessions');

        $this->client->clickLink('Выбрать');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('p', 'Билетов не осталось');
    }
}
