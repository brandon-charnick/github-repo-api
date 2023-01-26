FROM nginx:stable-alpine

# RUN apk add --update openssl
# RUN openssl req -x509 -newkey rsa:4096 -keyout /etc/ssl/private/nginx-selfsigned.key -out /etc/ssl/certs/nginx-selfsigned.crt -days 365 -nodes -subj "/C=US/ST=Arizona/L=Phoenix/O=Security/OU=Development/CN=localhost"

COPY default.conf /etc/nginx/conf.d/
RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf