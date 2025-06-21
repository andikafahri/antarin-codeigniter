# Gunakan image PHP resmi dengan CLI
FROM php:8.2-cli

# Install ekstensi PHP yang dibutuhkan CI4
RUN apt-get update && apt-get install -y \
git \
unzip \
zip \
libzip-dev \
libicu-dev \
&& docker-php-ext-install intl

# Copy Composer dari image Composer resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set direktori kerja
WORKDIR /var/www/html

# Copy semua file dari project ke dalam container
COPY . .

# Install dependency dari composer
RUN composer install

# Set permission folder writable
RUN chmod -R 777 writable

# Expose port (Railway pakai environment variable $PORT)
EXPOSE 8000

# Jalankan server CI4
CMD ["sh", "-c", "php spark serve --host=0.0.0.0 --port=$PORT"]
