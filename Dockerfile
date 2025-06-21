# Gunakan image PHP CLI
FROM php:8.2-cli

# Install dependency sistem & ekstensi PHP
RUN apt-get update && apt-get install -y \
git \
unzip \
zip \
libzip-dev \
libicu-dev \
&& docker-php-ext-install intl zip

# Copy Composer dari image resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set direktori kerja
WORKDIR /var/www/html

# Copy semua file project
COPY . .
COPY entrypoint.sh /entrypoint.sh

# Install dependensi PHP
RUN composer install

# Set permission folder writable
RUN chmod -R 777 writable
RUN chmod +x /entrypoint.sh

# Expose port (tidak wajib, tapi baik)
EXPOSE 8080

# Jalankan server CodeIgniter pakai shell agar $PORT bisa dibaca
CMD ["/entrypoint.sh"]

