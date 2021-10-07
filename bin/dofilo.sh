#!/bin/bash


php bin/console doctrine:schema:drop --full-database --force --no-interaction

php bin/console doctrine:migrations:migrate --no-interaction

php bin/console doctrine:schema:validate

php bin/console doctrine:fixtures:load --no-interaction