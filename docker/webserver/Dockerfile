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
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs
RUN node --version
RUN npm --version

COPY ./docker/webserver/conf/orocommerce.conf /opt/docker/etc/nginx/conf.d/
COPY ./docker/database/config.cnf /etc/mysql/conf.d/

