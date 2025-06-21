# Gunakan image PHP resmi dengan CLI
FROM php:8.2-cli

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
CMD ["php", "spark", "serve", "--host=0.0.0.0", "--port=8000"]
