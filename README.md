# 🚀 Welcome to  IBAN Validator Application! 🚀

An IBAN validator application allowing users to register, log in, and validate IBAN numbers. Users can enter IBANs, which are then validated and stored in a database if valid. Admins have access to a paginated list of entered IBANs.

* **User Registration and Login:** Secure user accounts.
* **IBAN Entry and Validation:** Robust IBAN validation logic.
* **Data Storage:** Securely store valid IBANs in a database.
* **Admin Privileges:** Special access for administrative tasks.
* **IBAN List:** Paginated list of entered IBANs for admins.

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
7. **Frontend Setup:**
   ```bash
    cd frontend
    npm install 
   ```
8. **Start development server::**
   ```bash
    npm run dev 
   ```