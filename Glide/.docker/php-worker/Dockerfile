ARG TARGET_PHP_VERSION
FROM php:${TARGET_PHP_VERSION}-cli

ARG SERVICE_DIR="./php-worker"
COPY ./.shared/scripts/ /tmp/scripts/
RUN chmod +x -R /tmp/scripts/

# set timezone
ARG TZ=UTC
RUN /tmp/scripts/set_timezone.sh ${TZ}

# add users
ARG APP_USER=www-data
ARG APP_GROUP=www-data
ARG APP_USER_ID=1000
ARG APP_GROUP_ID=1000

RUN /tmp/scripts/create_user.sh ${APP_USER} ${APP_GROUP} ${APP_USER_ID} ${APP_GROUP_ID}

RUN /tmp/scripts/install_php_extensions.sh

RUN /tmp/scripts/install_software.sh

# php config
COPY ./.shared/config/php/conf.d/*  /usr/local/etc/php/conf.d/

# install supervisor
RUN apt-get update -yqq && apt-get -f install -yqq supervisor

COPY ${SERVICE_DIR}/supervisord.conf /etc/supervisord.conf

ARG APP_CODE_PATH
ARG PHP_WORKER_COMMAND="php $APP_CODE_PATH/artisan queue:work"
ARG PHP_WORKER_COMMAND_ARGS
ARG PHP_WORKER_PROCESS_NUMBER

COPY ${SERVICE_DIR}/supervisord.d/laravel-worker.conf "/etc/supervisord.d/laravel-worker.conf"
RUN /tmp/scripts/modify_config.sh "/etc/supervisord.d/laravel-worker.conf" \
    "__APP_USER" \
    "${APP_USER}" \
 && /tmp/scripts/modify_config.sh "/etc/supervisord.d/laravel-worker.conf" \
    "__PROCESSES" \
    "${PHP_WORKER_PROCESS_NUMBER}" \
 && /tmp/scripts/modify_config.sh "/etc/supervisord.d/laravel-worker.conf" \
    "__COMMAND" \
    "${PHP_WORKER_COMMAND} ${PHP_WORKER_COMMAND_ARGS}" \
;

RUN cat "/etc/supervisord.d/laravel-worker.conf"
RUN cat "/etc/supervisord.d/laravel-worker.conf"

# Make sure the volumes have the correct ownership
ARG APP_CACHE_PATH
RUN mkdir -p "${APP_CACHE_PATH}" && chown ${APP_USER}: "${APP_CACHE_PATH}"
ARG APP_LOG_PATH
RUN mkdir -p "${APP_LOG_PATH}" && chown ${APP_USER}: "${APP_LOG_PATH}"

# CAUTION: supervisor writes logs here
WORKDIR "/etc/supervisord.d"

COPY ${SERVICE_DIR}/../.shared/scripts/docker-entrypoint/ /bin/docker-entrypoint/
RUN chmod +x -R /bin/docker-entrypoint/

RUN /tmp/scripts/cleanup.sh

ENTRYPOINT ["/bin/docker-entrypoint/resolve-docker-host-ip.sh","/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]
