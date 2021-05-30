- Склонивать проект
- Перейти в корень проекта и засетапить зависимости выполнив composer install  
- Создать БД(Я считаю что mysql уже установлен)
- Прописать в .env соединение к БД (DATABASE_URL=mysql://{user}:{password}@{host}:{port}/{db_name}?charset=utf8)
- После создания БД в корне проекта выполнить bin/console doctrine:schema:create для создания таблиц
- Необходимо выполнить bin/console doctrine:fixtures:load для заполнения таблиц 
- Установить запуск команды по крону(bin/console eps:parse:currency), сама инструкция в файле crontab.conf
- Для запуска сервера выполнить в корне symfony server:start -d
  * для этого предварительно нужно выполнить  curl -sS https://get.symfony.com/cli/installer | bash
- Отправить запрос типа: http://127.0.0.1:8001/v1/currencies/BTC?from=2021-05-28T10:35:09&to=2021-05-31T17:00:09
  * Порт может быть другой. from и to нужно - динамические переменные

Осталось сделать:
- Нужно настроить php cs and phpstan
- Есть TODO в коде. 