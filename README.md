# Introduction

NETVOD is an on-demand series web application. This application is open-source and the code can therefore be re-elected and completed in exchange for credit.

# Install Guide

Install LAMP, composer, and git on the server 

```bash
sudo apt install apache2 php libapache2-mod-php mariadb-server php-mysql composer git
```

Create website configuration on web server :

Create or replace file at `/etc/apache2/sites-available/000-default.conf` and fill this file with  
```apache
<VirtualHost *:80>
    DocumentRoot "/var/www/"
    <Directory "/var/www/">
        Options +FollowSymLinks
        AllowOverride all
        Require all granted
    </Directory>
    ErrorLog /var/log/apache2/error.netvod.com.log
    CustomLog /var/log/apache2/access.netvod.com.log combined
</VirtualHost>
```

Reload web server :

```bash
sudo systemctl reload apache2
```

## Create database for website
Enter in the command-line client of mariadb 

```bash
sudo mariadb -u root
```

Create database in SQL 

```sql
create database netvod
```
Close mariadb client and go back to bash 
```sql
exit
```
Clone repository to temp folder
```bash
cd netvod/
```

```bash
git clone https://github.com/Leonarddoo/NetVOD.git
```

Create tables required by application 

```bash
sudo mariadb -u root < tables.sql
```

Move **images, videos, index.php and style.css** files in `/var/html/`

Create netvod folder in /var 
```bash
mkdir /var/netvod/
```
Move `src/folder` and **composer.json** file of application in `/var/netvod`

Generate autoloader with composer and define path of autoloader in **index.php** 
```bash
cd /var/netvod/
composer install
```
Edit **index.php** with new path of autoloader

## Create file with database driver configuration for PHP 
Create `/var/netvod/db.config.ini` shape of **db.config.ini** (to complete) 
* driver=mysql
* username=[*user*]
* password=[*passwd*]
* host=localhost
* database=[*db*]

<mettre user guide ici>

# User Guide

The first time you arrive on NETVOD, you arrive on a page with two buttons (login/registration)

<ins>Go to the registration page where you must provide:</ins>
* A valid email address
* A password of at least 10 characters
* Password verification
  
Once the registration is complete you can go to the login page to log in.

Once this is done you will be able to freely browse the application, watch series, leave an opinion, put some in favorites etc..
