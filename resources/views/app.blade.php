<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Coding Challenge</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <script src="{!! mix('js/app.js') !!}" defer></script>
        <link href="{!! mix('css/app.css') !!}" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css"></script>
    </head>
    <body>
        <div id="app">
            <div class="container">
                <div class="row">
                    <nav class="navbar navbar-expand-lg col-12 bg-primary my-3">
                        <router-link class="nav-item nav-link text-white" to="/">Product</router-link>
                        <router-link class="nav-item nav-link text-white" to="/category">Category</router-link>
                    </nav>
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </body>
</html>
