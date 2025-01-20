FROM alpine:3

RUN apk update && apk add \
	php83 \
	php83-apache2 \
	&& rm -rf /var/cache/apk/*

RUN rm -r /var/www/localhost/htdocs/*

WORKDIR /var/www/localhost/htdocs

# Our source files.
COPY src/ ./

EXPOSE 80

ENTRYPOINT ["/usr/sbin/httpd", "-D", "FOREGROUND"]
