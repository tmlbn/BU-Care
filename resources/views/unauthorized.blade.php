<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BU-Care') }}</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
  </head>
  <body>
      <p style="font-size: 40px;">UNAUTHORIZED ACCESS</p>
      <footer>
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <p>&copy; 2023 BU-Care. All rights reserved.</p>
              <p>If you believe you received this error by mistake, please contact the Bicol University Health Services for assistance.</p>
            </div>
          </div>
        </div>
      </footer>
  </body>
</html>
  