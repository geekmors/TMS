# Time Tracking System Setup Guide

## Dependencies
- php
- apache - optional
- composer
- mysql
- git

## Setting up - 9/17/2021
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
4. create an .env file for storing your environment variables you can use the existing .env.example file by renaming it to .env or running the below command
    ```
    $ cp .env.example .env
    ```
5. run the below command to generate a APP_KEY
    ```
    $ php artisan key:generate
    ```
6. To test that you were successful run the below command to start the development server, if an error is thrown let Karl know in the group chat.
    ```
    $ php artisan serve
    ```
7. then open http://localhost:8000/ on your browser
8. If a page shows up with the text "Hello World!" then you were successful, if instead you see an error message, let Karl know in the group chat.