<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


**Installation**

1. **Clone the repository:**
   ```bash
   git clone https://github.com/bishrulhaq/iban-checker
   ```
2. **Backend Setup:**
   ```bash
   cd backend
   composer update
   ```
3. **Configure database: Edit .env file with database credentials.**

4. **Migrations and Seeding:**
   ```bash
   php artisan migrate:fresh --seed
   ```
5. **Fetch IBAN data:**
   ```bash
   php artisan iban:fetch
   ```
6. **Start the server:**
   ```bash 
   php artisan serve
   ```
