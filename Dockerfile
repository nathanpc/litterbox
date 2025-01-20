FROM alpine:3

RUN apk update && apk add \
    sed \
	php83 \
	php83-apache2 \
	&& rm -rf /var/cache/apk/*

RUN rm -r /var/www/localhost/htdocs/*

RUN sed -zie 's|\(<Directory "/var/www/localhost/htdocs">\)\(.*\)\(</Directory>\)|\1\nOptions Indexes\nAllowOverride All\nRequire all granted\n\3|g' /etc/apache2/httpd.conf && \
	sed -ie 's|/var/www/localhost/htdocs|/app|g' /etc/apache2/httpd.conf

WORKDIR /app

# Our source files.
COPY src/ ./

EXPOSE 80

ENTRYPOINT ["/usr/sbin/httpd", "-D", "FOREGROUND"]
