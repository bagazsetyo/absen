
<!DOCTYPE html>
<html lang="en">
  <head>
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
    <!-- ======== sidebar-nav start =========== -->
    <div class="position-fixed top-0 end-0 p-3 toast-not-found" style="z-index: 11">
      <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="7000">
          <div class="d-flex">
              <div class="toast-body text-white">
                  Not Found
              </div>
          <button type="button" class="btn-close me-2 m-auto btn-close-white" data-bs-dismiss="toast"> <i class="lni lni-close"></i> </button>
          </div>
      </div>
    </div>
    @include('includes.side')
    <div class="overlay"></div>
    <!-- ======== sidebar-nav end =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
      <!-- ========== header start ========== -->
        @include('includes.nav')
      <!-- ========== header end ========== -->

      <!-- ========== section start ========== -->
      <section class="section">
        @yield('content')
        <!-- end container -->
      </section>
      <!-- ========== section end ========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========= All Javascript files linkup ======== -->
    @stack('before-script')
    @include('includes.script')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
    @stack('after-script')
  </body>
</html>
