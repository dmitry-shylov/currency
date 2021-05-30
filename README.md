- Для запуска сервера
  /Users/mak/.symfony/bin/symfony server:start -d

- Зайти и создать БД
- Выполнить команду composer install  
- Выполнить команду bin/console doctrine:schema:create
- http://127.0.0.1:8001/v1/currencies/BTC?from=2021-05-28T10:35:09&to=2021-05-31T17:00:09
- Команда по крону - bin/console eps:parse:currency

Осталось сделать:
- Нужно настроить php cs and phpstan
- 