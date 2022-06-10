Результаты ревью:

- [x] Я предлагаю структуру папок привести к следующему виду
<pre>
src
+-- Controller
+-- DataFixtures
+-- Domain
|   +-- Booking
|   |   +-- Collection
|   |   +-- Command
|   |   +-- Entity
|   |   +-- Form
|   |   +-- Repository
|   +-- Kernel.php
templates
</pre>
- [x] FilmSessionController:19 При получении методами контроллера исключений приложение будет возвращать 500 ошибку, хочется видеть перехват и ошибку 404 (NotFoundHttpException)
- [x] FilmSessionController:21 В маршрутах не очень удачно стыкуются данные '/films', name: 'film_sessions. Предлагаю привести к одному смыслу, - фильмы или сеансы.
- [x] FilmSessionController:36 У symfony, есть конвертер параметров. Предлагаю ознакомиться и переделать https://symfony.com/doc/current/routing.html#parameter-conversion
- [x] FilmSessionController:37 имя $bus не отражает суть. Лучше будет переименовать в $messageBus.
- [x] FilmSessionController:39 Команда CreateTicketCommand после рефакторинга станет простой структурой данных. Можно ее инициализировать и передать в форму, для наполнения.
- [x] FilmSessionController:35 FilmSessionRepository в домене видел FilmSessionRepositoryInterface. Судя по всему план был его использовать в контроллере. Сейчас выглядит странно выделение интерфейса и не использование его.
- [x] FilmSessionController:48 Предлагаю унести на слой инфраструктуры(в handler) функционал создания клиента.
- [x] FilmSessionRepository предлагаю унести в домен. Так у нас принято делать в проектах.
- [x] FilmSessionRepositoryInterface не очень удачное именование методов. Лучше переименовать в findById и save. Чаще всего именно такое именование можно встретить на проектах у нас в компании
```php
interface FilmSessionRepositoryInterface
{
    public function findById(string $id): ?FilmSession;
    public function save(FilmSession $filmSession): void;
}
```
- [x] index.html.twig:17 лишний перенос и в строке 22 опечатка
- [x] index.html.twig при использовании twig можно обращаться к entity так: Можно сделать так: <li>Дата сеанса: {{ filmSession.dateTimeStartFilmSession|date('Y.m.d') }}</li>
- [x] show.html.twig:15 отсутствует отступ.
- [x] Имя для CreateTicketCommand выбрано неудачно, вводит в заблуждение. По факту команда не "создает билет", а бронирует место. Предлагаю переименовать.
- [x] CreateTicketCommand - Для создания билета тебе необходимы только "сеанс", "имя" и "номер" клиента.
- [x] После рефакторинга, в команде CreateTicketCommand останутся "простые" данные, которые легко будет валидировать перед выполнением операции.
- [x] Все handler-ы мы обычно уносим в подпапку, например:
<pre>
+-- Command
|   +-- Handler
|   |   +-- CreateTicketHandler.php
|   +-- CreateTicketCommand.php
</pre>
- [x] CreateTicketHandler:16 дурной тон использовать ManagerRegistry в handler, этого необходимо избегать использовать исключительно репозитории по возможности в конструкторе. 
Думаю что для этого handler-а будет лучше написать отдельный репозиторий FilmSessionRepository 
- [x] CreateTicketHandler в целом при разработке handler-a было произведено большое количество изменений в логике домена которых не должно быть:
1) checkTicketsAvail() - стал публичным, не думаю что это хорошая затея.
2) $ticket = $this->bookTicket($createTicketCommand); - Бронирование билета стало создавать билет.
3) private function updateCountTickets(CreateTicketCommand $createTicketCommand): void - очень странный метод. Который стал результатом серьезных ухудшений в рамках сущности.
- [x] NewClientType - предлагаю унести в соответствии с вышеупомянутой структурой, подумать над именованием, добавить для обязательных полей required.
- [x] Не понимаю какую проблему решает UuidService с точки зрения архитектуры. В любом случа Entity о сервисе знать не должны, т.е. UuidService::generate() должно выполняться на уровне инфраструктуры.
- [x] В Client есть 2 метода, которые похоже не используются getName(), getPhone()
- [x] FilmSession в целом все изменения методов сущности, ухудшили его использование. Предлагаю вернуться к изначальной версии, за исключением описания аттрибутов доктрины и добавления id в конструктор.
- [x] Film::filmLength напрашивается на изменение формата внутри домена. Предлагаю как прием, так и возврат значения привести к одному виду в рамках этого класса. 
- [ ] После внедрения доктрины в классы Film, FilmSession мы по сути храним в двух форматах одни и те же данные: $filmLength, $timeEndFilmSession. Думаю, что $timeEndFilmSession избыточен и его вполне нормально рассчитывать.
- [x] В README.md в 5п.п. мне, как разработчику предлагается "Запустите команду `composer install`" эта операция происходит за рамками контейнера, предлагаю это улучшить и выполнять composer install в контейнере resolventa_backend_internship_php-fpm_1
- [x] в конфиге doctrine.yaml фигурирует `alias: App` для домена. Мы обычно в качестве alias задаем название домена в данном случае `alias: Booking` 
- [x] предлагаю разбить фикстуру на 3 независимые.
- [ ] вернуть валидацию в ValueObjects
