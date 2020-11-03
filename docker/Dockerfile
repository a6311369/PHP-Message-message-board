FROM centos:centos7.8.2003

MAINTAINER Tuffy

WORKDIR /data

EXPOSE 80 443 9000

RUN yum install epel-release -y

RUN yum install http://rpms.remirepo.net/enterprise/remi-release-7.rpm -y
RUN yum install yum-utils -y
RUN yum install vim net-tools git -y
RUN yum install -y php73-php-fpm php73-php-cli php73-php-bcmath php73-php-gd php73-php-json php73-php-mbstring php73-php-mcrypt php73-php-mysqlnd php73-php-opcache php73-php-pdo php73-php-pecl-crypto php73-php-pecl-mcrypt php73-php-pecl-geoip php73-php-recode php73-php-snmp php73-php-soap php73-php-xmll php73-php-dom php73-php-zip php73-php-process php73-php-redis
RUN php73 -r "copy('https://install.phpcomposer.com/installer', 'composer-setup.php');"
RUN php73 composer-setup.php
RUN php73 -r "unlink('composer-setup.php');"
RUN ln -s /usr/bin/php73 /usr/local/bin/php
RUN mv composer.phar /usr/local/bin/composer
RUN yum install nginx -y
RUN systemctl enable nginx
RUN systemctl enable php73-php-fpm

CMD ["/usr/sbin/init"]