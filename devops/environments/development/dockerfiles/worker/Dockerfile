FROM ambientum/php:7.3

USER root

RUN echo '* * * * * cd /var/www/app && php artisan schedule:run' > /etc/crontabs/root

ENTRYPOINT crond && php artisan horizon
