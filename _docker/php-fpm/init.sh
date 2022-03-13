#!/usr/bin/env bash

echo "running init.sh"

cd /var/www/html

#composer install
php-fpm
bash ./scripts/tests/start-selenium.sh


#cd /var/www/html
#copy /usr/bin/geckodriver /var/www/html/drivers/
#copy /usr/bin/chromedriver /var/www/html/drivers/



