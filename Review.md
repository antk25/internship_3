Результаты ревью этап "тестирование":

- [x] Предлагаю переименовать фикстуры, заменив в названии EmptySeats на FreeSeats.
- [x] $filmSession в фикстурах - очень странное решение. Предлагаю не использовать массив. тем более у переменной 2 ответственности, что максимально странно. Если хочется оставить массив, его лучше вынести в константу.
- [x] AvatarFilmSessionWithFiveEmptySeatsFixtures:26 предлагаю конструкцию преобразовать в следующий вид, будет более понятно, что происходит:
```phpt
new \DateInterval(sprintf('PT%dM', self::FILM_DURATION_IN_MINUTES)),
```
- [x] AvatarFilmSessionWithFiveEmptySeatsFixtures:28 Предлагаю отказаться от использования псевдонима и использовать DateTimeImmutable::__construct()
- [x] Мы в проектах фикстуры складываем в Doctrine\Common\DataFixtures\ReferenceRepository. Пример кода:
```phpt
final class AvatarFilmSessionWithFiveEmptySeatsFixtures extends Fixture
{
    public const AVATAR_FILM_SESSION_WITH_FIVE_FREE_SEATS = 'avatarFilmSessionWithFiveFreeSeats';

    public function load(ObjectManager $manager): void
    {
        
        $filmSession = new FilmSession(...);

        $manager->persist($filmSession);
        $manager->flush();

        $this->addReference(self::AVATAR_FILM_SESSION_WITH_FIVE_FREE_SEATS, $filmSession);
    }
}

Далее в теста возможно такое использование: 

        $referenceRepository = $this->loadFixtures([
            AvatarFilmSessionWithFiveEmptySeatsFixtures::class,
        ])->getReferenceRepository();

        $filmSession = $referenceRepository->getReference(AvatarFilmSessionWithFiveEmptySeatsFixtures::AVATAR_FILM_SESSION_WITH_FIVE_FREE_SEATS);
```
- [x] FilmSessionTest::setUp() Создание $filmSession лучше унести в отдельный приватный метод.
- [x] FilmSessionTest:23 $this->film - это приватное не используемое в дальнейшем свойство. Его необходимо преобразовать в локальную переменную.
- [x] Во всех тестах необходимо придерживаться Arrange-Act-Assert.
- [x] Переименовать тестирующие методы, чтобы они соответствовали реальному сценарию. Например: testTicketBookWhenNoSeatsAvailable -> testBookingTicketWithoutSeatsShouldGiveException
- [x] В тесте testBookTicketIncreaseNumberOfBookedTickets проверка `$this->assertEquals(0, $this->filmSession->getCountOfTicketsAvailable());` - избыточна.
- [x] В тесте testBookTicketWhenNoSeatsThrowOutException именование у переменных $client1, $client2 не содержательно. Предлагаю переименовать.
- [x] В CreateTicketCommandHandlerTest:29, код теста неявно связан с фикстурой, чтобы этого избежать мы используем ReferenceRepository(см. пример выше)
- [x] Для BookTicketCommand тестирование пограничных условий валидации было бы отлично добавить.
