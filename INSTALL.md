1. Переместить файлы на сервер, например, в каталог /srv/www/nautilus
2. Перейти в корень проекта (/srv/www/nautilus)
#3. Запустить php composer.phar update  для создания автозагрузчика классов - не актуально, т.к. приложил автозагрузчик в архиве
4. Запустить php-скрипт: php index.php 

Класс замены данных: modules/Application/Grabber.php
Класс замены исходными данными: modules/Application/Revert.php
Пример использования класса: modules/Application/Application.php