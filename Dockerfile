FROM php:8.2-fpm

WORKDIR /var/www/html
COPY . .

RUN apt-get update \
    && apt-get install -y gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python3 \
    && mkdir -p /etc/apt/keyrings\
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg\
    && mkdir -p ~/.gnupg \
    && chmod 600 ~/.gnupg \
    && echo "disable-ipv6" >> ~/.gnupg/dirmngr.conf \
    && apt-key adv --homedir ~/.gnupg --keyserver hkps://keyserver.ubuntu.com --recv-keys 0x14AA40EC0831756756D7F66C4F4EA0AAE5267A6C \
    && echo "deb https://ppa.launchpadcontent.net/ondrej/php/ubuntu jammy main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get install -y php8.2-cli php8.2-dev \
    php8.2-pgsql php8.2-sqlite3 php8.2-gd \
    php8.2-curl \
    php8.2-imap php8.2-mysql php8.2-mbstring \
    php8.2-xml php8.2-zip php8.2-bcmath php8.2-soap \
    php8.2-intl php8.2-readline \
    php8.2-ldap \
    php8.2-msgpack php8.2-igbinary php8.2-redis php8.2-swoole \
    php8.2-memcached php8.2-pcov php8.2-xdebug \
    && php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list\
    && apt-get update \
    && apt-get install -y nodejs \
    && npm install -g npm \
    && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" > /etc/apt/sources.list.d/yarn.list \
    && echo "deb http://apt.postgresql.org/pub/repos/apt jammy-pgdg main" > /etc/apt/sources.list.d/pgdg.list \
    && curl --silent -o - https://www.postgresql.org/media/keys/ACCC4CF8.asc | apt-key add - \
    && apt-get update \
    && apt-get install -y yarn \
    && apt-get install -y mysql-client \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN composer install
ENV APP_ENV=production
EXPOSE 9000

# Command để chạy ứng dụng
CMD ["php", "-f", "public/index.php"]