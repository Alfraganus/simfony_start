# Test task done

## Author

task was developed by Sulaymonov Gulomjon.

## Project Information

This project uses Apache as the web server, PHP 8.2, and MySQL 8.0 as the database management system.
## Calculation of Price (POST)
{{server_url}}/product/get-price

## Payment operation (POST)
{{server_url}}/product/pay

## Operations

To set up and run this project, follow these steps:

   ```bash
   composer install
   ```

1. Create the database by running the following command:
   ```bash
   php bin/console doctrine:database:create
   ```
2. Apply database migrations to create the necessary database schema:

 ```bash
  php bin/console doctrine:migrations:migrate
  ```
3.Load initial fixtures (if any) into the database:
 ```bash
  php bin/console doctrine:fixtures:load
  ```
Sample products in DB:

|   Name    |  Price  |
|:---------:|:-------:|
|  Iphone   |   100   |
| Наушники  |    20   |
|  Чехол    |    10   |

sample coupons :

|   Code   |   Type    |   Value   | Is Active |
|:--------:|:---------:|:---------:|:---------:|
|  C12345  |   fixed   |    50     |     1     |
|  C12346  |   fixed   |    10     |     1     |
|  C12347  |   fixed   |    25     |     1     |
|  C12348  | percentage |    15     |     1     |
|  C12349  | percentage |     5     |     1     |

sample countries and tax code

|   Name   |  Regex Tax Number  |  Tax Percentage  |
|:--------:|:------------------:|:----------------:|
| Germany  |     DE123456789    |        19        |
|  Italy   |     IT123456789    |        22        |
|  Greece  |     GR123456789    |        24        |
|  France  |     FR123456789    |        20        |
