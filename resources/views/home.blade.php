<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <link rel="stylesheet" href="/css/all.css">
    

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    
</head>
<body class="bg-gray-100 h-screen antialiased leading-none">
    <div id="app">
        <main-app></main-app>
    </div>
</body>
<script src="{{ mix('/js/app.js') }}"></script>
</html>
