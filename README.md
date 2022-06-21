AGPAY countries and currencies API.

To Setup Your Local Database
-------------------------------------------------------------
* Create database name agpay
* Inside sql/ directory there's database.sql. Run it to create your DB tables.

To Import csv Files To Your Database
--------------------------------------------------------------
* Extract the project folder to your server directory. 
* Move to your project directory and run [composer install] to instll the dependencies
* Rename the .env.example to .env and input your database credenttials
* Go to your browser and load http://localhost/[project folder]/importmaster.php

AGPAY API
---------------------------------------------------------------
* http://localhost/agpay/[tableName]/?limit=[limitValue]&offset=[offsetValue]&search=[searchValue]
* Description
*** [tableName] as defined on the database (currencies or countries).
*** [limitValue] number of records per page
*** [offsetValue] Next page
*** [searchValue] searches official_name and common_name of countries and currencies; can be empty.
*** LIMIT and OFFSET parameters are always required.

*** To get joint currencies and countries tables as one output: http://localhost/agpay/?limit=[limitValue]&offset=[offsetValue]&search=[searchValue]
*** To get countries table ONLY: http://localhost/agpay/countries/?limit=[limitValue]&offset=[offsetValue]&search=[searchValue]
*** To get currencies table ONLY: http://localhost/agpay/currencies/?limit=[limitValue]&offset=[offsetValue]&search=[searchValue]

Testing the API
---------------------------------------------------------------
You can test the API with a tool like Postman or Thunder client. First, go to the project directory and start the PHP server: php -S 127.0.0.1:8000 -t public
Then connect to 127.0.0.1:8000 with Postman or Thunder client and send http requests. 