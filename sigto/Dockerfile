FROM php:8.2-apache

# Instalar la extensión mysqli
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get update -y
# Copiar el código de la aplicación al contenedor
COPY ./ /var/www/html/

# Exponer el puerto 80
EXPOSE 80
