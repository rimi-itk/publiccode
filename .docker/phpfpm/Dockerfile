FROM itkdev/php8.1-fpm:latest

RUN apt update \
    && apt install --yes php8.1-pgsql \
    # Clean up
    && rm -rf /var/lib/apt/lists/*
