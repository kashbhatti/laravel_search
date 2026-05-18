<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Laravel VueJS Search</title>

    <!-- CSS -->
    <link
        href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
        rel="stylesheet"
        integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
        crossorigin="anonymous"
    >

    <!-- Styles / Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset("js/underscore-min.js") }}"></script>
    @vite(["resources/sass/style.scss", "resources/js/app.js"])
</head>

<body>
    <div id="searchApp">
        <search-image-list></search-image-list>
    </div>
</body>
</html>
