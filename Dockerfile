# Usa una imagen oficial de PHP con Apache
FROM php:8.1-apache

# Copia todo el código fuente al directorio donde Apache sirve archivos
COPY . /var/www/html/

# Instala dependencias necesarias para PHP (si usas Composer)
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Habilita el módulo de reescritura de Apache para aplicaciones PHP
RUN a2enmod rewrite

# Expone el puerto 80
EXPOSE 80

# Inicia Apache en primer plano
CMD ["apache2-foreground"]
