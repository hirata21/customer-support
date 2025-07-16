# お問い合わせフォーム

## 環境構築手順

# 1. Dockerコンテナのビルドと起動
docker-compose build
docker-compose up -d

# 2. Laravelの依存パッケージをインストール
docker-compose exec php composer install

# 3. .envファイルを作成
cp .env.example .env

# 4. アプリケーションキーの生成
docker-compose exec php php artisan key:generate

# 5. データベースマイグレーションの実行
docker-compose exec php php artisan migrate

# 6. シーディングの実行
docker-compose exec php php artisan db:seed


## 使用技術(実行環境)
- Laravel 8.75
- PHP 7.4.9
- MySQL 8.0.26
- Nginx 1.21.1
- phpMyAdmin（ポート8080で接続）
- Docker / Docker Compose v3.8

## ER図
(./images/er.png)

## URL
- アプリケーション：http://localhost
- phpMyAdmin：http://localhost:8080
  （ログインユーザー：`laravel_user` / パスワード：`laravel_pass`）

