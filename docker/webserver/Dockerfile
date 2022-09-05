FROM webdevops/php-nginx-dev:8.1@sha256:4abe7821298b83ff72454df1c1c69378e6f1219a7688af4569c8c34df5ea5018
#FROM webdevops/php-nginx:8.1@sha256:1c335f1c7e798616617ad715b6c083b50a64150d7c0e3fd80f9db0365bc31172

RUN apt-get update && apt-get install -y -q --no-install-recommends \
        apt-transport-https \
        build-essential \
        ca-certificates \
        curl \
        git \
        libssl-dev \
        wget \
        acl \
    && rm -rf /var/lib/apt/lists/*

# Install Node
#RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -
#RUN apt-get install -y nodejs
#RUN node --version
#RUN npm --version

# Install and Configure Drush
RUN curl -sS https://getcomposer.org/installer | php    \
    && mv composer.phar /usr/local/bin/composer         \
    && ln -s /usr/local/bin/composer /usr/bin/composer  \
    && git clone https://github.com/drush-ops/drush.git /usr/local/src/drush \
    && cd /usr/local/src/drush && git checkout 10.x      \
    && ln -s /usr/local/src/drush/drush /usr/bin/drush
RUN cd /usr/local/src/drush && composer install

#Install and Configure Drupal Console -> https://github.com/hechoendrupal/drupal-console-launcher
RUN cd /tmp && curl https://github.com/hechoendrupal/drupal-console-launcher/releases/download/1.9.7/drupal.phar -L -o drupal.phar  \
    && mv drupal.phar /usr/local/bin/drupal \
    && chmod +x /usr/local/bin/drupal

COPY ./docker/webserver/conf/orocommerce.conf /opt/docker/etc/nginx/conf.d/
COPY ./docker/database/config.cnf /etc/mysql/conf.d/

