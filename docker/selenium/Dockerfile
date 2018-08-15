FROM alpine:3.8

# Selenium
RUN apk --no-cache add \
	chromium \
	chromium-chromedriver \
	curl \
	libexif \
	py-pip \
	python \
	udev \
	unzip \
	xvfb

RUN	pip install selenium && \
	pip install pyvirtualdisplay

# PHP
RUN apk add --no-cache \
    php7 \
    php7-apcu \
    php7-ctype \
    php7-curl \
    php7-dev \
    php7-dom \
    php7-fpm \
    php7-gd \
    php7-iconv \
    php7-imagick \
    php7-intl \
    php7-json \
    php7-mbstring \
    php7-mcrypt \
    php7-opcache \
    php7-openssl \
    php7-pdo \
    php7-pdo_pgsql \
    php7-pear \
    php7-pgsql \
    php7-phar \
    php7-session \
    php7-simplexml \
    php7-tokenizer \
    php7-xml \
    php7-xmlwriter \
    php7-zip \
    php7-zlib

ENTRYPOINT php

# Java

## Add Glibc
RUN apk --no-cache add \
	openjdk7-jre
