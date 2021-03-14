Installing in your device:

Make sure you are running command prompt and already "cd"-ed to your project folder.

Make sure composer and npm/nodejs related-stuff are installed.

1. Run ```composer install```.
2. Run ```npm install```.
3. Run ```cp .env.example .env```.
4. Run ```php artisan key:generate```.
5. Fill in database credentials in your .env file.
6. Run ```php artisan migrate```.
7. You're good to go.
