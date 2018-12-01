FROM centos:7

RUN yum update -y && \
    yum install -y epel-release && \
    yum install -y http://rpms.famillecollet.com/enterprise/remi-release-7.rpm

RUN yum install -y nginx && \
    yum install -y --enablerepo=remi-php72 php php-cli php-pdo php-fpm php-json php-mysqlnd php-mbstring php-opcache && \
    yum clean all

RUN yum install -y --enablerepo=remi-php72 php72-php-phalcon3
RUN cp /etc/opt/remi/php72/php.d/50-phalcon.ini /etc/php.d/
ENV PATH /opt/remi/php72/root/usr/lib64/php/modules:$PATH
#WORKDIR /usr/local/src
#RUN git clone https://github.com/phalcon/cphalcon
#WORKDIR /usr/local/src/cphalcon/build
#RUN ./install

# /etc/php.ini
RUN sed -i.bak -e "s|expose_php = On|expose_php = Off|" \
#    -e "s|memory_limit = 128M|memory_limit = 128M|" \
#    -e "s|post_max_size = 8M|post_max_size = 8M|" \
#    -e "s|upload_max_filesize = 2M|upload_max_filesize = 2M|" \
    -e "s|;date.timezone =|date.timezone = Asia/Tokyo|" \
    -e "s|;mbstring.language = Japanese|mbstring.language = Japanese|" \
    -e "s|;mbstring.encoding_translation = Off|mbstring.encoding_translation = Off|" \
    -e "s|;mbstring.detect_order = auto|mbstring.detect_order = UTF-8,SJIS,EUC-JP,JIS,ASCII|" \
    /etc/php.ini

# /etc/php.d/phalcon.ini
#RUN echo 'extension=phalcon.so' | tee /etc/php.d/phalcon.ini

# /etc/php-fpm.d/www.conf
RUN sed -i.bak -e "s|user = apache|user = nginx|" \
    -e "s|group = apache|group = nginx|" \
    -e "s|listen = 127.0.0.1:9000|listen = /run/php-fpm/php-fpm.sock|" \
    -e "s|;listen.owner = nobody|listen.owner = nginx|" \
    -e "s|;listen.group = nobody|listen.group = nginx|" \
    /etc/php-fpm.d/www.conf

# /etc/nginx/nginx.conf
RUN mv /etc/nginx/nginx.conf /etc/nginx/nginx.conf.bak
COPY etc/nginx/nginx.conf /etc/nginx/nginx.conf

# /etc/nginx/conf.d/default.conf 
COPY etc/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
#COPY etc/nginx/default.d/default.conf /etc/nginx/default.d/default.conf

# /etc/nginx/conf.d/security.conf 
#COPY etc/nginx/conf.d/security.conf /etc/nginx/conf.d/security.conf

# /etc/nginx/default.d/php.conf
#COPY etc/nginx/default.d/php.conf /etc/nginx/default.d/php.conf

# /etc/nginx/default.d/security.conf
#COPY etc/nginx/default.d/security.conf /etc/nginx/default.d/security.conf

# /etc/nginx/conf.d/phalcon.conf

RUN systemctl enable php-fpm
RUN systemctl enable nginx

# /usr/share/nginx/html
RUN echo '<?php phpinfo(); ?>' | tee /usr/share/nginx/html/phpinfo.php

EXPOSE 80
CMD ["/sbin/init"]
