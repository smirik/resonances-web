# docker run -it php:7.3-fpm-alpine /bin/bash
# ---- Base Node ----
FROM php:7.3-fpm-alpine AS base

RUN apk --update add \
    nginx \
    supervisor \
    git \
    icu-dev \
    libzip-dev \
    zip

RUN docker-php-ext-install \
    intl \
    opcache \
    pdo \
    pdo_mysql \
    zip

COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_MEMORY_LIMIT -1
RUN composer global require hirak/prestissimo --no-plugins --no-scripts
RUN adduser -D -g 'www' www
RUN chown -R www:www /var/lib/nginx /var/tmp/nginx/
# ARG HOST_UID

# RUN if [ ! -z "${HOST_UID}" ]; then \
#         deluser www-data \
#         && addgroup www-data \
#         && adduser -u "${HOST_UID}" -G www-data -H -s /bin/sh -D www-data; \
#     fi

# ENV WWW_DATA_UID ${HOST_UID}

# Preparing
RUN mkdir -p /var/www/html && chown -R www /var/www/html
# Set working directory
WORKDIR /var/www/html
# Copy project file
COPY package.json .
COPY package-lock.json .
COPY composer.json .
COPY composer.lock .

#
# ---- Dependencies ----
FROM base AS dependencies
RUN apk add --update python build-base nodejs nodejs-npm
# install ALL node_modules, including 'devDependencies'
RUN npm install --silent
RUN composer install

# 
# ---- Test & Build ----
# run linters, setup and tests
FROM dependencies AS build
COPY . .
# Setup environment variables
RUN ./node_modules/.bin/encore production

# ---- Release ----
FROM base AS release
RUN rm -rf /var/cache/apk/*
# copy production node_modules
COPY --from=build /var/www/html/public/build ./public/build
COPY --from=dependencies /var/www/html/vendor ./vendor

# Setup environment variables
ENV NODE_ENV=production
# expose port and define CMD
EXPOSE 9000
COPY ./config/docker/php/symfony.ini /usr/local/etc/php/conf.d/
COPY ./config/docker/php/symfony.pool.conf /usr/local/etc/php-fpm.d/
COPY ./config/docker/nginx/nginx.conf /etc/nginx/
COPY ./config/docker/nginx/symfony.conf /etc/nginx/sites-available/symfony.conf
COPY ./config/docker/supervisord.conf /etc/supervisord.conf
COPY . .
CMD ["/usr/bin/supervisord", "-n"]
