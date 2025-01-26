FROM php:8.3-apache
RUN apt-get update && apt-get upgrade -y
# Install mysqli php extention to connect with the database.
RUN docker-php-ext-install mysqli pdo_mysql 
COPY src/* /var/www/html 
EXPOSE 80
ENTRYPOINT [ "/usr/sbin/apache2ctl" , "-D" , "FOREGROUND"]
