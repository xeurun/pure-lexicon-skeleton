FROM php:5.6-fpm

# Install selected extensions and other stuff
RUN apt-get update
RUN apt-get install -y php5-cli libpng-dev libjpeg-dev libxml2-dev php5-xdebug php5-json php5-gd
RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install xml
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql 
RUN docker-php-ext-install bcmath

ADD composer /usr/bin/composer
ADD ./.ssh/id_rsa ~/.ssh/id_rsa
ADD ./.ssh/id_rsa.pub ~/.ssh/id_rsa.pub

WORKDIR "/var/www"
