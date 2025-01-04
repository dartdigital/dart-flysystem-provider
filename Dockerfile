FROM php:8.2-apache-buster as base

RUN set -eux; \
	EXPECTED_VERSION="$(curl -L https://composer.github.io/installer.sig)"; \
	curl -sS https://getcomposer.org/installer -O; \
	ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'installer');")"; \
	if [ "$EXPECTED_VERSION" != "$ACTUAL_CHECKSUM" ]; then >&2 echo 'ERROR: Invalid installer checksum'; exit 1; fi; \
	php installer --version=2.0.12; \
	mv composer.phar /usr/local/bin/composer;

RUN set -eux; \
	mkdir -p /.composer; \
	chown -R 1000:1000 /.composer;

RUN set -eux; \
	apt-get update; \
    apt-get install -y --no-install-recommends git zip unzip libzip-dev libicu-dev libxml2-dev imagemagick libmagickwand-dev libpq-dev xvfb wget fonts-inconsolata fontconfig xfonts-100dpi xfonts-75dpi xfonts-base default-mysql-client; \
	apt-get autoclean; \
	apt-get autoremove -y;

RUN set -eux; \
	docker-php-ext-install bcmath ctype intl iconv session simplexml pdo pgsql pdo_pgsql pdo_mysql mysqli zip; \
	docker-php-ext-enable bcmath ctype intl iconv session simplexml pdo pgsql pdo_pgsql pdo_mysql mysqli zip;

RUN set -eux; \
    pecl install imagick; \
    docker-php-ext-enable imagick;

COPY .configs/000-default.conf /etc/apache2/sites-enabled/000-default.conf
COPY .configs/custom.ini "$PHP_INI_DIR/conf.d/custom.ini"

RUN a2enmod rewrite
RUN a2enmod headers