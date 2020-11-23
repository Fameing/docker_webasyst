# Webasyst Docker с PHP-FPM 7.4, nginx и MariaDb 10.1
Конфигурация docker-compose для работы с фреймфорком и приложениями Webasyst

Эта конфигурация содержит набор из следующих контейнеров:

* **MariaDb** (10.1)
* **nginx**
* **php-fpm** (php 7.4)
* **mailhog** (smtp сервер для тестирования)

Также приложены настроенные файлы конфигурации для разработки и CSV с набором товаров для тестового магазина

## Быстрый старт

1. Скачайте архив этого репозитория
1. Создайте следующую структуру директорий:
 * `docker` - директория для файлов из этого репозитория
 * `webasyst` - директория для файлов фреймворка

        ```
            app (назовите как хотите)
                docker
                    ... сюда распакуйте содержимое архива из этого репозитория ...
                webasyst
                    ... здесь будут файлы фреймворка и приложений ...
        ```
3. зайдите в директорию `webasyst` и скопируйте в неё файлы фреймворка (и других нужных вам приложений). Я предпочитаю клонировать репозитории webasyst из Github:

    ```
    git clone git@github.com:webasyst/webasyst-framework.git .
    ```    
и, если нужен Shop-Script  и у вас есть доступ к его репозиторию,
    ```
    git clone git@github.com:webasyst/shop-script.git wa-apps/shop
    ```    
4. Зайдите в директорию `docker/wa-config` и скопируйте все её содержимое в директорию `webasyst/wa-config`. Проверьте файл `apps.php`, вероятно нужно убрать комментарии у некоторых строк
5. **Права доступа к файлам!!!** разрешите полный доступ для всех ко всему содержимому папки `webasyst`. Например зайдите в директорию `app` или как вы там её назвали и выполните команду `sudo chmod a+rw -R webasyst`
6. Зайдите в директорию `docker` и выполните команду
    ```
    docker-compose up
    ```
    Через некоторое время все контейнеры запустятся и ваш новый фреймворк будет доступен по адресу `localhost:8100`. Также по адресу `localhost:8101` будет доступен web-интерфейс MailHog — сервера для отладки e-mail отправок. Все письма, отправляемые фреймворком, независимо от отправителя и получателя, будут попадать сюда (и больше никуда).

## PhpMyAdmin

PhpMyAdmin будет доступен по адресу `localhost:8104`.

## Демо-товары для Магазина

В папке `docker/demo-data` лежит CSV файл с товарами демо-магазина Webasyst. Его можно импортировать штатным инструментом Shop-Script

## Xdebug

Xdebug настроен, но перед тем как пробовать его запустить, проверьте следующие параметры:

1. В файле `docker-compose.yml` указан `remote_host` в `XDEBUG_CONFIG`, это ip вашего контейнера
2. В файле `php-ini-overrides.ini` прочекайте путь до установленного xdebug и измените в случае необходимости

#### Xdebug + PhpStorm
Для использования Xdebug в PhpStorm, нужно настроить:

1. `Languages and Frameworks/PHP/Debug` - установите порт Xdebug 19000
2. `Languages and Frameworks/PHP/Debug/DBGp Proxy`:
    * IDEKEY: **PHPSTORM**
    * Host: **127.0.0.1**
    * Port: **19000**
3. `Languages and Frameworks/PHP/Servers` - создайте новый сервер с именем `xdebug-docker`:
   * Host: **127.0.0.1**
   * Port: **19000**
   * Debugger: **Xdebug**
   
   Затем настройте мапы, путь должен начинаться с `/webasyst`, например:
   `/home/Plugins/my_plugin >> /webasyst/wa-apps/shop/plugins/my_plugin`
