FROM dunglas/frankenphp

#RUN cp $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
RUN cp $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
RUN install-php-extensions mysqli

COPY ./src /app/public

#ENV FRANKENPHP_CONFIG="worker ./public/index.php"
