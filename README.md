Start project: 

composer install

npm install 

php artisan serve --host= --port=

npm run dev -- --host=

php artisan migrate

php artisan db:seed

php artisan passport:install

php artisan schedule:work

send request post to {{BASE_URL_HOME}}/oauth/token 
        with json: 
            {
                "grant_type" : "password",
                "client_id" : "98cb24ea-3271-4819-b186-1240bc0445b9",
                "client_secret" : "ks3b3rq2SEAjjCdI8NjgOIBK4PW1nkQxJLuXA4ha",
                "username" : "theanh090602@gmail.com",
                "password" : "anhtran96",
                "scope" : "*"
            }


