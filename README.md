# API Books

API Books.

## About the project

- Laravel 10
- Requires PHP >= 8.1
- Mysql 8

## How to run the api?

**Step 1: Clone the project, run the following commands:**

**Step 2: Create file .env**
- cp .env.example .env
- Set APP_URL in .env: APP_URL=localhost:8000/api/
- Set database settings in .env 
- DB_CONNECTION=mysql
- DB_HOST=db
- DB_PORT=3306 
- DB_DATABASE=api_books 
- DB_USERNAME=api_books
- DB_PASSWORD=api_books
 <br>

**Step 3: Run docker**
- docker-composer up -d

**Step 4: Install dependences:**
- docker-compose exec app composer install

**Step 5: Generate key in .env**
- docker-compose exec app php artisan key:generate

**Step 6: Install passport**
- docker-compose exec app php artisan passport:install

**Step 7: Generate tables**
- docker-compose exec app php artisan migrate