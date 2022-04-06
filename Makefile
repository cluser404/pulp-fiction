all: vendor/autoload.php
	php -S 0.0.0.0:5252 src/main.php

vendor/autoload.php: composer.lock
	composer install