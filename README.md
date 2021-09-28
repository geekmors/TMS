# Time Tracking System Setup Guide

## Dependencies
- PHP
- apache - optional
- composer
- MySQL
- git

## Setting up - 9/25/2021
To setup the project open a terminal/console and follow these steps.
1. At an appropriate location, clone the repo using 
    ```
   $ git clone https://github.com/amayakarl/TimeTrackingSystem.git 
    ```
2. go into the cloned project folder and, use git to move into the dev branch
3. install dependencies using composer
    ```
    $ composer install
    ```    
4. create an .env file for storing your environment variables you can use the existing .env.example file by renaming it to .env or running the below command:   
    ```
    $ cp .env.example .env
    ```
    ***Note**: The command above assumes the use of a bash based terminal.*
5. run the below command to generate a APP_KEY
    ```
    $ php artisan key:generate
    ```
6. make sure you create a database in MySQL, the database name does not matter
7. go back to your cloned folder and make sure that your .env file's DB_* variables are updated according to your database connection settings.   
    example:
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=time_management_system #same as the database name from step 6.
    DB_USERNAME=root
    DB_PASSWORD=
    ```
8. Once your .env file has been updated with the correct database connection settings, run the below command.
    ```
    $ php artisan migrate
    ```
9. To make sure you have default data in your database, run the below command:
    ```
    $ php artisan db:seed
    ```
10. Create a Symbolic link to the storage/app/ folder to save files using the below command.
    ```
    $php artisan storage:link
    ```
11. Add Google client Id and secret to your .env file. **Message Karl so he provides his one** 
    ```
    GOOGLE_CLIENT_ID="<random_numbers>.apps.googleusercontent.com"
    GOOGLE_CLIENT_SECRET="<random_security_key>"
    GOOGLE_REDIRECT="http://localhost:8000/authorized" # add this line too
    ```
    ***Note*: never share the key nor the client id with anyone outside the group after being provided by Karl.**

12. To test that you were successful run the below command to start the development server, if an error is thrown let Karl know in the group chat.

    ```
    $ php artisan serve
    ```
13. then open http://localhost:8000/ on your browser
14. If a page shows up with the text "Hello World!" then you were successful, if instead you see an error message, let Karl know in the group chat.

---
If you need help setting up, let Karl know via the group chat and have him get into a call to go through the process.

Learn more about Laravel via the [Laravel docs](https://laravel.com/docs/8.x)