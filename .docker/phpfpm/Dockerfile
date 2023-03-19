FROM itkdev/php8.1-fpm:latest

# Install php8.1-pgsql
RUN apt update \
    && apt install --yes php8.1-pgsql \
    # Clean up
    && apt autoremove --purge && apt clean \
    && rm -rf /var/lib/apt/lists/*
