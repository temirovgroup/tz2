Inflact

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    tests/               contains tests for frontend application
    views/               contains view files for the Web application

    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
runtime/             contains files generated during runtime
web/                 contains the entry script and Web resources
```

INSTALL
-------
* for docker machine:
```
docker-machine start
eval (docker-machine env default)
```

* generate or copy you ssh key for docker (~/.ssh/ingramerdocker) - not works in MacOS

* clone enc_password_generator in node-auth directory
```  
git clone git@git.producktv.tech:vendor/inflact/enc_password_generator.git node-auth
```

* clone mqtt in mqtt directory
```  
git clone git@git.producktv.tech:vendor/inflact/mqtt.git
```

* start docker containers:
```
docker-compose up
```

* open fpm container:
```
docker exec -it inflact-fpm-1 /bin/bash
```

add ssh key to docker container (if you use MacOS):
```
docker cp ~/.ssh/id_rsa {CONTAINER_ID}:/root/.ssh/id_rsa2

chmod 700 /root/.ssh
chmod 600 /root/.ssh/id_rsa2
eval `ssh-agent -s`
ssh-add ~/.ssh/id_rsa2
```

* Создать в БД схемы: `ingramer`, `ingramer_dti`, `ingramer_logs`  
``` 
CREATE DATABASE ingramer CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
CREATE DATABASE ingramer_dti CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
CREATE DATABASE ingramer_logs CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```


* init project:
```
php init
composer install
php yii migrate --sm=rbac --all=0
php yii rbac/init
php yii migrate

cd node-auth
npm i

cd mqtt
npm i
npm run build
cp .env.dev .env
```

* `crontab -e` - add cron tasks
```
*/1 * * * * /usr/bin/php /var/www/yii campaign > /var/www/runtime/logs/cron-campaigns.txt 2>&1
*/1 * * * * /usr/bin/php /var/www/yii task/worker > /var/www/runtime/logs/cron-tasks-worker.txt 2>&1
*/1 * * * * /usr/bin/php /var/www/yii cron/index > /var/www/runtime/logs/cron-statistic.txt 2>&1
*/30 * * * * /usr/bin/php /var/www/yii account/worker > /var/www/runtime/logs/cron-followers-worker.txt 2>&1
*/5 * * * * /usr/bin/php /var/www/yii cron/live-activity > /var/www/runtime/logs/cron-live-activity.txt 2>&1
*/10 * * * * /usr/bin/php /var/www/yii task/stop-hung > /var/www/runtime/logs/task-stop-hung.txt 2>&1
30 5 * * * /usr/bin/php /var/www/yii cron/rating > /var/www/runtime/logs/cron-rating.txt 2>&1
```
* TODO написать как добавить common аккаунты чтоб добавление таргетинга работало
```
в табличку user_variables добавляем name=rent_account_common
```
TESTS
-----
http://test.ingramer.loc:4444/ui - тут selenium grid

* Создать базы данных `ingramer_test` `ingramer_test_logs` `ingramer_test_dti`
* Выполнить миграции:
```
php yii_test migrate --sm=rbac --all=0
php yii_test rbac/init
php yii_test migrate
```

### Как смотреть селениум тесты в реальном времени:
* скачиваем клиент: https://www.realvnc.com/en/connect/download/viewer/
* вводим адрес: 127.0.0.1:5901 - chrome, 5902 - firefox
* `codecept run`

## Индексация для Manticore
```
docker-compose run manticore indexer --rotate -c /etc/manticoresearch/manticore.conf profiles_test_idx
docker-compose run manticore indexer --rotate -c /etc/manticoresearch/manticore.conf hashtags_idx
```
После создания индексов перезапустить

# Internationalization

- создание новой конфигурации

```
# create config file
php yii message/config /var/www/fronted/messages/config.php
```

- далее создание файлов переводов, команда генерации не затирает предыдущие переводы

```
# generate files by config
php yii message /var/www/frontend/messages/config.php
```

# Preland

Для работы с палкой мы работаем не напрямую, а через прокладки. Это отдельный проект в гитлабе и его подгружаем на локалку и дев в папку `web`

- `cd web`
- `git clone git@repo.ingapi.com:dev/preland.git`

# Авторизованное апи инстаграма

Некоторые запросы из инграмера должны выполняться через авторизованное АПИ инстаграма,
это значит что нам нужны служебные аккаунты чтобы выполнять через них запросы.
Для этого нужно:
- Иметь хотя бы один аккаунт с активной веб-авторизацией
  - Если проект поднят с нуля и пока нет никакого аккаунта, то нужно создать себе пользователя с бесплатным доступом к промо
    - Для этого в админке редактируешь своего пользователя и даешь ему 1 промо аккаунт, и заполняешь Paid finish какой-нибудь будущей датой
    - Далее заходишь в этого пользователя и в кабинете добавляешь и авторизуешь свой аккаунт, он далее в шагах ниже будет настроен как служебный и некоторые запросы будут выполняться через него.  
- Потом в таблицу user_variables добавляешь две строки у которых
  - user_id айди юзера авторизованного аккаунта
  - value айди авторизованного аккаунта
  - name у одной строки пишешь rent_account_downloader, у другой rent_account_common
  
После этого по идее все запросы могут идти через этот аккаунт.
Мониторить результаты этих запросов можно в таблице log_proxy в БД