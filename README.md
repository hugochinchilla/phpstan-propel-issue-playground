# Setup

 * Edit `.env` and set `UID` to your user UID (usually 1000)
 * Install deps: `docker-compose run --rm php php composer.phar install`
 * Create autoloader: `docker-compose run --rm php php composer.phar dump-autoload`

Reproduce issue:

```
docker-compose run --rm php php vendor/bin/phpstan analyse --level 4 -c .phpstan.neon src/ExampleClass.php
```
