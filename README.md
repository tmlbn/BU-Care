<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://github.com/suou09/BU-Care/blob/master/public/media/BU-Carelogo1.png?raw=true" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About BU-Care

BU-Care is a web application designed specifically for Bicol University Health services. It serves as a platform for patients to conveniently submit their health records and schedule clinic appointments. On the other hand, physicians and nurses can efficiently navigate through the health records, storing vital medical information such as patient health records and daily consultations. BU-Care aims to streamline the process of managing patient health records and enhance the overall efficiency of healthcare services provided by Bicol University Health services.

## Installation
1.	Prerequisites:<br>
•	Make sure you have PHP installed on your machine. You can check the installed PHP version by running the following command in the command line: 
`php -v`
<br>
<i>*Note: BU-Care requires PHP version 8.2.1 or later. <br>
If you have an older version, consider upgrading to PHP 8.2.1 or later from https://www.php.net/downloads.php (choose the appropriate platform for your device).<br>
</i>
•	Ensure you have Composer installed. You can verify this by running the following command in the command line: 
`composer -v`
<br>
<i>*Note: Composer is a dependency management tool for PHP. <br>
If you don't have Composer installed, you can download the latest version from https://getcomposer.org/download/ (choose the appropriate platform for your device).<br>
</i>
<br>
•	Install MySQL for the database and XAMPP for the server.<br>
<br>
2.	Clone or download the repository of the application.<br><br>
3.	Install Dependencies:<br>
•	Open a command prompt or terminal and navigate to the project directory.<br>
•	Run the following command to install the project dependencies: 
`composer install`
<br>
4.	Environment Configuration:<br>
•	Duplicate the .env.example file and rename the copy to .env.<br>
<img src="https://i.imgur.com/FJagmzp_d.webp?maxwidth=760&fidelity=grand" width="400" alt="Laravel Logo"><br>
<br>
•	In the command prompt or terminal, run the following command: `php artisan key:generate`
<br>
•	Open the .env file and set up the MySQL and XAMPP database connection details, such as database name, username, and password.<br>
*Note: The details shown in the image might not be the same for your case.<br>
<img src="https://i.imgur.com/56NyjNM_d.webp?maxwidth=760&fidelity=grand" width="400" alt="Laravel Logo"><br>
<br>
5.	Start Apache and MySQL modules in XAMPP.<br>
•	Open XAMPP Control Panel and start the Apache and MySQL modules.<br>
<img src="https://i.imgur.com/hCAnMAj_d.webp?maxwidth=760&fidelity=grand" width="400" alt="Laravel Logo"><br>
<br>
6.	Run Database Migrations:<br>
•	To create the required tables in the database, run the following command: `php artisan migrate` <br>
<br>
7.	Serve the Application:<br>
•	You can use Laravel's built-in server to run the application. In the command prompt or terminal, run the following command: `php artisan serve` <br>
•	By default, the application will be served at http://localhost:8000 or http://127.0.0.1:8000/.<br>
<br>
8.	Access the Application:<br>
•	Open a web browser and navigate to the URL where the application is being served (http://localhost:8000 by default).<br>
•	Open http://localhost/phpmyadmin to navigate the application’s database with GUI.<br>
<br>

## The Team

- **[Tom Jherald G. Labini](https://github.com/suou09)**
- **[Kayle V. Garrido](https://github.com/kylgrrd)**
- **[Austin R. Nieves](https://github.com/austin-nieves)**
- **[John Francis Rhei Bien](https://github.com/RheiBien)**
