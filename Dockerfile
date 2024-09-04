# ベースイメージとして公式のPHPイメージを使用
FROM php:8.1-fpm

# 必要なパッケージをインストール
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    vim \
    libonig-dev

# Docker上でcomposerをインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリを設定
WORKDIR /var/www

# Laravelプロジェクトをコピー
COPY . /var/www

# Composerの依存パッケージをインストール
RUN composer install --no-dev --optimize-autoloader

# .envファイルの設定（必要に応じて）
COPY .env.example .env

# APP_KEYの生成
RUN php artisan key:generate

# 必要な権限を付与
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# ポート80を開放
EXPOSE 80

# PHP-FPMを起動
CMD ["php-fpm"]
