FROM php:7.2-apache

# Install mysql pdo plugin used by php
RUN docker-php-ext-install -j$(nproc) pdo_mysql

RUN a2enmod ssl headers rewrite

