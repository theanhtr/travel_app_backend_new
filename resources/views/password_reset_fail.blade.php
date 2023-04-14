<!DOCTYPE html>
<html lang="en" class="">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Travel App</title>
    <link rel = "icon" href = 
        "{{URL::asset('/images/logo.svg')}}"
        type = "image/svg">
    </head>

    <style> 
        .filter-white{
            filter: invert(100%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(100%) contrast(100%);
        }
    </style>
  <body>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
            <img class="w-28 h-28 mr-2 filter-white" src="{{URL::asset('/images/logo.svg')}}" alt="logo">
                Travel App    
            </a>
            <div class="w-full p-6 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md dark:bg-gray-800 dark:border-gray-700 sm:p-8">
                <h2 class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    <div class="alert alert-success">
                        Reset Password Get Error: 
                            <div class="alert alert-danger text-red-700">
                                {{$error}}
                            </div>
                    </div>    
                </h2>
            </div>
        </div>
    </section>
  </body>
</html>