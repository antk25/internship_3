# Сервис бронирования билетов в кино 

1. Скопировать репозиторий командой git clone https://github.com/antk25/internship_3.git
2. Перейдите в директорию `docker` командой `cd docker`
3. Скопируйте файл `.env.example` в `.env` командой `cp .env.example .env`
4. Запустите docker контейнеры командой `docker-compose up -d --build`
5. Вернитесь в рабочую директорию `cd ..`
6. Запустите команду `composer install`
7. Установите миграции и фикстуры командой `docker exec -it docker-php-fpm-1 bash install/migrations.sh`
8. Перейдите на [страницу списка сеансов](http://localhost/films)
