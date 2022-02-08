FROM nginx:latest

RUN rm /etc/nginx/conf.d/default.conf
COPY ./conf/ /etc/nginx/conf.d/
RUN echo "upstream php-upstream { server fpm:9000; }" > /etc/nginx/conf.d/upstream.conf
RUN usermod -u 1000 www-data
