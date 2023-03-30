Start project: 
    1) composer install
    2) npm install 
    3) php artisan serve --host= --port=
    4) npm run dev -- --host=
    5) php artisan migrate
    6) php artisan passport:install
    7) send request post to {{BASE_URL_HOME}}/oauth/token 
        with json: 
            {
                "grant_type" : "password",
                "client_id" : "98cb24ea-3271-4819-b186-1240bc0445b9",
                "client_secret" : "ks3b3rq2SEAjjCdI8NjgOIBK4PW1nkQxJLuXA4ha",
                "username" : "theanh090602@gmail.com",
                "password" : "anhtran96",
                "scope" : "*"
            }