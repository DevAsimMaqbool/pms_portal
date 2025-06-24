<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-assets-path="{{ asset('admin/assets') }}/" data-template="vertical-menu-template">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/x-icon" href="https://demos.pixinvent.com/vuexy-html-admin-template/assets/img/favicon/favicon.ico" />
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com/" />
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;ampdisplay=swap" rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/iconify-icons.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/node-waves/node-waves.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/pickr/pickr-themes.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/core.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-auth.css') }}" />

      
        <script src="{{ asset('admin/assets/vendor/js/helpers.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/js/template-customizer.js') }}"></script>
        <script src="{{ asset('admin/assets/js/config.js') }}"></script>
    </head>
    <body>
          <div class="container-xxl">
            <div class="authentication-wrapper authentication-basic container-p-y">
              <div class="authentication-inner py-6">
                <!-- Login -->
                <div class="card">
                  <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-6">
                      <a href="" class="app-brand-link">
                      <x-application-logo class="app-brand-logo demo" />
                      </a>
                    </div>
                    <!-- /Logo -->
                    {{ $slot }}
                  </div>
                </div>
                <!-- /Login -->
              </div>
            </div>
          </div>
        <script src="{{ asset('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/popper/popper.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/js/bootstrap.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/@algolia/autocomplete-js.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/pickr/pickr.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/hammer/hammer.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/i18n/i18n.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/js/menu.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/@form-validation/popular.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>
        <script src="{{ asset('admin/assets/js/main.js') }}"></script>
        <script src="{{ asset('admin/assets/js/pages-auth.js') }}"></script>

    </body>
</html>
