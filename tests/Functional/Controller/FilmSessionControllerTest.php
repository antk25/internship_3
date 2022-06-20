<?php

namespace App\Tests\Functional\Controller;

use App\DataFixtures\AvatarFilmSessionWithFiveFreeSeatsFixtures;
use App\DataFixtures\HobbitFilmSessionWithNoFreeSeatsFixtures;
use App\Domain\Booking\Repository\FilmSessionRepositoryInterface;
use App\Tests\Functional\FunctionalTestCase;

final class FilmSessionControllerTest extends FunctionalTestCase
{
    private FilmSessionRepositoryInterface $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = self::getContainer()->get(FilmSessionRepositoryInterface::class);
    }

    public function testOnSessionsPageShouldDisplayAllAvailableFilmSessions(): void
    {
        $this->loadFixtures([
            HobbitFilmSessionWithNoFreeSeatsFixtures::class,
            AvatarFilmSessionWithFiveFreeSeatsFixtures::class,
        ]);

        $crawler = $this->client->request('GET', 'film-sessions');

        $this->assertResponseIsSuccessful();
        $this->assertCount($this->repository->count([]), $crawler->filter('h2'));
    }

    public function testBookTicketViaFormIfSuccessfulRedirectToFilmSessions(): void
    {
        $this->loadFixtures([AvatarFilmSessionWithFiveFreeSeatsFixtures::class]);

        $this->client->request('GET', 'film-sessions');
        $this->client->clickLink('Выбрать');
        $this->client->submitForm('Save', [
            'book_ticket[name]' => 'Федор',
            'book_ticket[phone]' => '89565263535',
        ]);
        $this->client->followRedirect();

        $this->assertPageTitleContains('Список сеансов');
        $this->assertSelectorTextContains('p.number_of_seats', 'Кол-во свободных мест: 4');
    }

    public function testIfNoSeatsAvailableShouldBeDisplayNoTicketsLeft(): void
    {
        $this->loadFixtures([HobbitFilmSessionWithNoFreeSeatsFixtures::class]);

        $this->client->request('GET', 'film-sessions');
        $this->client->clickLink('Выбрать');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('p', 'Билетов не осталось');
    }
}
