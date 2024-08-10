# TICKETIO PROJECT - HOW TO RUN

# Requirements:
- PHP 8.3.4 or higher
- Node 18.0.0 or higher
- MySql 
#### Do not forget to install, composer, inertia, vue and laravel on your machine

# Usage: 
```
git clone https://github.com/magspeixoto/TicketProject.git
cp .env.example .env
npm install
composer update
php artisan key:generate
php artisan cache:clear && php artisan config:clear
php artisan migrate
```

- Create environment file in the root of the project - .env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tickets
DB_USERNAME=root
DB_PASSWORD=root
``` 
- Update and install dependencies of the project
```npm install```  

- Run laravel PHP server and Database
```
php artisan migrate
php artisan migrate:refresh --seed 
```  

- Run vite web server
```npm run dev```

























