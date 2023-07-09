
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="assets/images/favicon.svg"
      type="image/x-icon"
    />
    <title>@yield('title', 'Absen')</title>

    @stack('before-style')
    @include('includes.style')
    @stack('after-style')
    @vite(['resources/js/app.js'])
    <!-- ========== All CSS files linkup ========= -->
  </head>
  <body>
    <main class="p-5">
      <!-- ========== section start ========== -->
      <section class="section">
        @yield('content')
        <!-- end container -->
      </section>
      <!-- ========== section end ========== -->
    </main>

    <!-- ========= All Javascript files linkup ======== -->
    @stack('before-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    @stack('after-script')
  </body>
</html>
