<!doctype html>
<html lang="en">
  <head>
    @include('layout.partials.head')
  </head>
  <body>
  @include('layout.partials.nav')
    <main role="main" class="container">
      <div class="starter-template">
        @yield('content')
      </div>
    </main>
  @include('layout.partials.footer-scripts');
  </body>
</html>
