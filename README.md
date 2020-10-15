# WPPL_DolanKuy_Backend
The Team :<br>
- Ulima Inas Shabrina<br>
- I Gede Kresna PA<br>
- Belinda Anindya KW<br>
- Gilang Taufiq A<br>
- Zul Fauzi O<br>
- Eka Darma W<br>

# How to be contributor
Get Started
- Clone this repository using VSCode :D
- $composer install
- rename .env.example files to .env
- $php artisan serve
- (error message generate app key) Click "Generate Key"
- Refresh

Connect with this Repository
- Go to your own branch
- Push to your own branch
- Make a pull Request

Connect with Database
- Make new DB in phpmyadmin
- config your db name in .env files
- $php artisan migrate

# Project Information
DolanKuy adalah sebuah platform Website, Desktop dan mobile yang memuat katalog wisata di daerah

# Database Information
Database yang kami pakai untuk aplikasi MVP adalah PHPMySQL dengan 6 Table yaitu :
1. Table User (Account user, Privilege : user(create), admin(delete))
2. Table Kuliner (List tempat kuliner dengan detailnya, Privilege : admin(CRUD))
3. Table SPBU_ATM (List tempat SPBU dan ATM dengan detailnya, Privilege : admin(CRUD))
4. Table Market (List tempat market dengan detailnya, Privilege : admin(CRUD))
5. Table Tempat_Ibadah (List tempat ibadah dengan detailnya, Privilege : admin(CRUD))
6. Table List_Wisata (List tempat wisata dengan detailnya, Privilege : admin(CRUD))
