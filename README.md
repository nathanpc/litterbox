# 📦 Litter Box

A simple solution to upload and share files extremely quickly with strangers on
the internet.

## Main Objective

The goal of this project is to provide a quick and super simple solution that
allows you, and only you, to upload files to a server you control and make them
available on the internet for other people.

## Setup

Setting this project up is extremely simple thanks to the magic of Docker. All
that you have to do is create a `docker-compose.yml` file such as this:

```yaml
---
services:
  app:
    build: '.'
    restart: unless-stopped
    ports:
      - '8001:80'
    volumes:
      - ./uploads:/var/www/localhost/htdocs/u
```

And after running `docker compose up -d` you should have the system up and
running.

## License

This project is licensed under the
[Mozilla Public License Version 2.0](https://www.mozilla.org/en-US/MPL/2.0/).
