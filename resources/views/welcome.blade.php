<!doctype html>
<html class=" layout-navbar-fixed layout-wide " dir="ltr" data-skin="default" data-bs-theme="light"
  data-assets-path="{{ asset('admin/assets') }}/" data-template="front-pages"
  lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>The Superior Group</title>
  <link rel="canonical"
    href="https://themeforest.net/item/vuexy-vuejs-html-laravel-admin-dashboard-template/23328599" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('admin/assets/img/favicon/favicon.ico') }}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/iconify-icons.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/node-waves/node-waves.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/pickr/pickr-themes.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/core.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/front-page.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/front-page-help-center.css') }}" />

  <script src="{{ asset('admin/assets/vendor/js/helpers.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/js/template-customizer.js') }}"></script>
  <script src="{{ asset('admin/assets/js/front-config.js') }}"></script>

</head>

<body>
  <script src="{{ asset('admin/assets/vendor/js/dropdown-hover.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/js/mega-dropdown.js') }}"></script><!-- Navbar: Start -->
  <nav class="layout-navbar shadow-none py-0">
    <div class="container">
      <div class="navbar navbar-expand-lg landing-navbar px-3 px-md-8">
        <!-- Menu logo wrapper: Start -->
        <div class="navbar-brand app-brand demo d-flex py-0 me-4 me-xl-8 ms-0">
          <!-- Mobile menu toggle: Start-->
          <button class="navbar-toggler border-0 px-0 me-4" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="icon-base ti tabler-menu-2 icon-lg align-middle text-heading fw-medium"></i>
          </button>
          <!-- Mobile menu toggle: End-->
          <a href="/" class="app-brand-link">
            <img style="width: 140px;" src="{{ asset('admin/assets/img/avatars/superior.svg') }}">
          </a>
        </div>
        <!-- Menu logo wrapper: End -->
        <!-- Menu wrapper: Start -->
        <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
          <button class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 scaleX-n1-rtl p-2"
            type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="icon-base ti tabler-x icon-lg"></i>
          </button>
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link fw-medium" aria-current="page" href="/">Home</a>
            </li>

          </ul>
        </div>
        <div class="landing-menu-overlay d-lg-none"></div>
        <!-- Menu wrapper: End -->
        <!-- Toolbar: Start -->
        <ul class="navbar-nav flex-row align-items-center ms-auto">

          <!-- / Style Switcher-->

          <!-- navbar button: Start -->
          @if (Route::has('login'))
            @if (session()->has('access_token') && session()->has('user_id'))
                <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-1">
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                        Dashboard
                    </a>
                </li>
            @else
                <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-1">
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <span class="tf-icons icon-base ti tabler-login scaleX-n1-rtl me-md-1"></span>
                        <span class="d-none d-md-block">Login</span>
                    </a>
                </li>
            @endif
        @endif
          <!-- navbar button: End -->
        </ul>
        <!-- Toolbar: End -->
      </div>
    </div>
  </nav>
  <!-- Navbar: End -->
  <!-- Sections:Start -->

  <!-- Help Center Header: Start -->
  <!-- <section class="section-py first-section-pt help-center-header position-relative overflow-hidden">
    <img class="banner-bg-img z-n1" src="{{ asset('admin/assets/img/pages/header.png') }}" alt="Help center header" />
    <h4 class="text-center text-primary">Hello, how can we help?</h4>
    <div class="input-wrapper mb-4 input-group input-group-merge position-relative mx-auto">
      <span class="input-group-text" id="basic-addon1"><i class="icon-base ti tabler-search"></i></span>
      <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" />
    </div>
    <p class="text-center px-4 mb-0">The Assessment Portal Dashboard for Employees provides a centralized interface where employees can view assigned assessments, check deadlines, and monitor their progress. It displays important statistics such as completed, pending, or overdue tasks. Employees can start new assessments directly from the dashboard and review past results or feedback. The layout is designed to be user-friendly, offering quick access to essential tools and information.</p>
  </section> --><br><br>
  <!-- Help Center Header: End -->
  <!-- Popular Articles: Start -->
  <section class="section-py">
    <div class="container">
      <h4 class="text-center mb-6">Performance Management Solution</h4>
      <div class="row">
        <div class="col-lg-10 mx-auto">
          <div class="row g-6">
            <div class="col-xl-4 col-md-6">
              <div class="card border shadow-none">
                <div class="card-body text-center">
                  <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g opacity="0.2">
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M48.2351 33.6218L41.1211 25.0804C41.393 30.314 40.1016 36.4086 36.1141 43.364L42.9109 48.8015C43.1526 48.9935 43.4393 49.1205 43.7438 49.1706C44.0484 49.2207 44.3607 49.1922 44.6511 49.0879C44.9415 48.9835 45.2005 48.8067 45.4035 48.5742C45.6065 48.3417 45.7467 48.0612 45.8109 47.7593L48.5976 35.1625C48.6648 34.8954 48.667 34.6161 48.6039 34.348C48.5408 34.08 48.4144 33.8309 48.2351 33.6218ZM9.62888 33.7578L16.7429 25.239C16.4711 30.4726 17.7625 36.5672 21.75 43.5L14.9531 48.9375C14.7129 49.1294 14.4279 49.257 14.1248 49.3084C13.8217 49.3598 13.5106 49.3333 13.2206 49.2314C12.9305 49.1294 12.6712 48.9554 12.467 48.7256C12.2628 48.4958 12.1203 48.2179 12.0531 47.9179L9.26638 35.2984C9.1992 35.0313 9.19705 34.7521 9.26013 34.484C9.3232 34.2159 9.44966 33.9669 9.62888 33.7578Z"
                        fill="currentColor" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M48.2351 33.6218L41.1211 25.0804C41.393 30.314 40.1016 36.4086 36.1141 43.364L42.9109 48.8015C43.1526 48.9935 43.4393 49.1205 43.7438 49.1706C44.0484 49.2207 44.3607 49.1922 44.6511 49.0879C44.9415 48.9835 45.2005 48.8067 45.4035 48.5742C45.6065 48.3417 45.7467 48.0612 45.8109 47.7593L48.5976 35.1625C48.6648 34.8954 48.667 34.6161 48.6039 34.348C48.5408 34.08 48.4144 33.8309 48.2351 33.6218ZM9.62888 33.7578L16.7429 25.239C16.4711 30.4726 17.7625 36.5672 21.75 43.5L14.9531 48.9375C14.7129 49.1294 14.4279 49.257 14.1248 49.3084C13.8217 49.3598 13.5106 49.3333 13.2206 49.2314C12.9305 49.1294 12.6712 48.9554 12.467 48.7256C12.2628 48.4958 12.1203 48.2179 12.0531 47.9179L9.26638 35.2984C9.1992 35.0313 9.19705 34.7521 9.26013 34.484C9.3232 34.2159 9.44966 33.9669 9.62888 33.7578Z"
                        fill="white" fill-opacity="0.2" />
                    </g>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M27.235 3.71096C27.7312 3.30004 28.3553 3.07507 28.9999 3.07507C29.6459 3.07507 30.2715 3.30111 30.7683 3.71388C32.9647 5.50218 37.7192 9.93865 40.3437 16.7605C41.2551 19.1295 41.9046 21.7738 42.1067 24.6785L49.1354 33.1129C49.416 33.4422 49.6141 33.8337 49.7132 34.2549C49.8117 34.6734 49.8096 35.1092 49.7073 35.5266L46.9233 48.1336L46.9226 48.1367C46.8183 48.6021 46.5973 49.0334 46.2804 49.3899C45.9635 49.7465 45.5611 50.0165 45.1111 50.1747C44.6611 50.3329 44.1782 50.3741 43.7079 50.2943C43.2376 50.2145 42.7953 50.0165 42.4226 49.7187L42.4222 49.7183L35.8992 44.5H22.1007L15.5778 49.7183L15.5773 49.7187C15.2046 50.0165 14.7624 50.2146 14.2921 50.2943C13.8218 50.3741 13.3389 50.333 12.8889 50.1748C12.4389 50.0165 12.0365 49.7465 11.7196 49.3899C11.4027 49.0334 11.1817 48.6021 11.0773 48.1367L11.0766 48.1336L8.29268 35.5266C8.19032 35.1092 8.18824 34.6734 8.28671 34.2549C8.38587 33.8335 8.58413 33.4418 8.86498 33.1124L15.7606 24.8552C15.9445 21.8769 16.6066 19.1694 17.5467 16.749C20.1971 9.92535 25.0133 5.48954 27.235 3.71096ZM40.1374 25.2385C40.1225 25.1572 40.1179 25.0747 40.1232 24.9929C39.9491 22.2126 39.3336 19.705 38.4771 17.4787C36.0283 11.1135 31.5663 6.94197 29.5015 5.26152L29.4916 5.25349L29.4917 5.25343C29.3537 5.1382 29.1796 5.07507 28.9999 5.07507C28.8201 5.07507 28.646 5.1382 28.5081 5.25343L28.4917 5.26678C26.4054 6.93588 21.8836 11.1072 19.411 17.4732C18.5219 19.7622 17.8919 22.3492 17.7428 25.2243C17.7435 25.2674 17.7414 25.3105 17.7365 25.3534C17.5077 30.2529 18.6768 35.9841 22.3314 42.5H35.6625C39.2712 35.9325 40.398 30.163 40.1374 25.2385ZM47.6029 34.398L42.1455 27.8491C41.9426 32.4347 40.608 37.5834 37.5337 43.2463L43.6711 48.1562C43.7787 48.2422 43.9065 48.2994 44.0424 48.3225C44.1782 48.3455 44.3177 48.3337 44.4477 48.2879C44.5777 48.2422 44.694 48.1642 44.7855 48.0612C44.8768 47.9585 44.9406 47.8343 44.9708 47.7003L44.9711 47.6992L47.7571 35.0828L47.7604 35.0681L47.7638 35.0544C47.792 34.9425 47.7929 34.8254 47.7664 34.713C47.74 34.6006 47.687 34.4962 47.6118 34.4086L47.6028 34.398L47.6029 34.398ZM15.7471 27.9916L10.3964 34.3988L10.3882 34.4086L10.3881 34.4086C10.313 34.4962 10.26 34.6006 10.2335 34.713C10.2071 34.8254 10.208 34.9425 10.2362 35.0544C10.2385 35.0639 10.2408 35.0733 10.2429 35.0828L13.0289 47.6992L13.0292 47.7004C13.0594 47.8344 13.1232 47.9586 13.2144 48.0612C13.306 48.1642 13.4222 48.2423 13.5522 48.288C13.6822 48.3337 13.8217 48.3455 13.9576 48.3225C14.0934 48.2995 14.2212 48.2422 14.3289 48.1562L20.4604 43.251C17.3566 37.647 15.985 32.5442 15.7471 27.9916ZM24.375 50.75C24.375 50.1977 24.8227 49.75 25.375 49.75H32.625C33.1773 49.75 33.625 50.1977 33.625 50.75C33.625 51.3022 33.1773 51.75 32.625 51.75H25.375C24.8227 51.75 24.375 51.3022 24.375 50.75ZM31.7187 21.75C31.7187 23.2515 30.5015 24.4687 29 24.4687C27.4985 24.4687 26.2812 23.2515 26.2812 21.75C26.2812 20.2484 27.4985 19.0312 29 19.0312C30.5015 19.0312 31.7187 20.2484 31.7187 21.75Z"
                      fill="currentColor" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M27.235 3.71096C27.7312 3.30004 28.3553 3.07507 28.9999 3.07507C29.6459 3.07507 30.2715 3.30111 30.7683 3.71388C32.9647 5.50218 37.7192 9.93865 40.3437 16.7605C41.2551 19.1295 41.9046 21.7738 42.1067 24.6785L49.1354 33.1129C49.416 33.4422 49.6141 33.8337 49.7132 34.2549C49.8117 34.6734 49.8096 35.1092 49.7073 35.5266L46.9233 48.1336L46.9226 48.1367C46.8183 48.6021 46.5973 49.0334 46.2804 49.3899C45.9635 49.7465 45.5611 50.0165 45.1111 50.1747C44.6611 50.3329 44.1782 50.3741 43.7079 50.2943C43.2376 50.2145 42.7953 50.0165 42.4226 49.7187L42.4222 49.7183L35.8992 44.5H22.1007L15.5778 49.7183L15.5773 49.7187C15.2046 50.0165 14.7624 50.2146 14.2921 50.2943C13.8218 50.3741 13.3389 50.333 12.8889 50.1748C12.4389 50.0165 12.0365 49.7465 11.7196 49.3899C11.4027 49.0334 11.1817 48.6021 11.0773 48.1367L11.0766 48.1336L8.29268 35.5266C8.19032 35.1092 8.18824 34.6734 8.28671 34.2549C8.38587 33.8335 8.58413 33.4418 8.86498 33.1124L15.7606 24.8552C15.9445 21.8769 16.6066 19.1694 17.5467 16.749C20.1971 9.92535 25.0133 5.48954 27.235 3.71096ZM40.1374 25.2385C40.1225 25.1572 40.1179 25.0747 40.1232 24.9929C39.9491 22.2126 39.3336 19.705 38.4771 17.4787C36.0283 11.1135 31.5663 6.94197 29.5015 5.26152L29.4916 5.25349L29.4917 5.25343C29.3537 5.1382 29.1796 5.07507 28.9999 5.07507C28.8201 5.07507 28.646 5.1382 28.5081 5.25343L28.4917 5.26678C26.4054 6.93588 21.8836 11.1072 19.411 17.4732C18.5219 19.7622 17.8919 22.3492 17.7428 25.2243C17.7435 25.2674 17.7414 25.3105 17.7365 25.3534C17.5077 30.2529 18.6768 35.9841 22.3314 42.5H35.6625C39.2712 35.9325 40.398 30.163 40.1374 25.2385ZM47.6029 34.398L42.1455 27.8491C41.9426 32.4347 40.608 37.5834 37.5337 43.2463L43.6711 48.1562C43.7787 48.2422 43.9065 48.2994 44.0424 48.3225C44.1782 48.3455 44.3177 48.3337 44.4477 48.2879C44.5777 48.2422 44.694 48.1642 44.7855 48.0612C44.8768 47.9585 44.9406 47.8343 44.9708 47.7003L44.9711 47.6992L47.7571 35.0828L47.7604 35.0681L47.7638 35.0544C47.792 34.9425 47.7929 34.8254 47.7664 34.713C47.74 34.6006 47.687 34.4962 47.6118 34.4086L47.6028 34.398L47.6029 34.398ZM15.7471 27.9916L10.3964 34.3988L10.3882 34.4086L10.3881 34.4086C10.313 34.4962 10.26 34.6006 10.2335 34.713C10.2071 34.8254 10.208 34.9425 10.2362 35.0544C10.2385 35.0639 10.2408 35.0733 10.2429 35.0828L13.0289 47.6992L13.0292 47.7004C13.0594 47.8344 13.1232 47.9586 13.2144 48.0612C13.306 48.1642 13.4222 48.2423 13.5522 48.288C13.6822 48.3337 13.8217 48.3455 13.9576 48.3225C14.0934 48.2995 14.2212 48.2422 14.3289 48.1562L20.4604 43.251C17.3566 37.647 15.985 32.5442 15.7471 27.9916ZM24.375 50.75C24.375 50.1977 24.8227 49.75 25.375 49.75H32.625C33.1773 49.75 33.625 50.1977 33.625 50.75C33.625 51.3022 33.1773 51.75 32.625 51.75H25.375C24.8227 51.75 24.375 51.3022 24.375 50.75ZM31.7187 21.75C31.7187 23.2515 30.5015 24.4687 29 24.4687C27.4985 24.4687 26.2812 23.2515 26.2812 21.75C26.2812 20.2484 27.4985 19.0312 29 19.0312C30.5015 19.0312 31.7187 20.2484 31.7187 21.75Z"
                      fill="white" fill-opacity="0.2" />
                  </svg>
                  <h5 class="my-3">Assigned Assessments</h5>
                  <p class="mb-3">Displays a list of assessments allocated to the employee with due dates.</p>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-md-6">
              <div class="card border shadow-none">
                <div class="card-body text-center">
                  <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M32.2689 8.56722C31.7876 9.05354 31.3688 9.84814 31.029 10.8704C30.6946 11.8767 30.4652 13.0152 30.31 14.1032C30.1553 15.1872 30.0776 16.197 30.0386 16.9371C30.0358 16.991 30.0332 17.0434 30.0307 17.0943C30.0816 17.0918 30.134 17.0892 30.1879 17.0864C30.928 17.0475 31.9378 16.9697 33.0218 16.815C34.1098 16.6598 35.2483 16.4304 36.2546 16.096C37.2769 15.7562 38.0715 15.3374 38.5578 14.8561C39.3907 14.0223 39.8587 12.8919 39.8587 11.7133C39.8587 10.5339 39.3901 9.4028 38.5562 8.56883C37.7222 7.73487 36.5911 7.26636 35.4117 7.26636C34.2331 7.26636 33.1027 7.73427 32.2689 8.56722ZM39.2633 15.5649L39.9704 16.272C41.1794 15.0629 41.8587 13.4231 41.8587 11.7133C41.8587 10.0035 41.1794 8.36365 39.9704 7.15462C38.7614 5.94559 37.1216 5.26636 35.4117 5.26636C33.7019 5.26636 32.0621 5.94559 30.853 7.15461L30.8499 7.15774C30.0518 7.96296 29.5111 9.09639 29.1311 10.2396C29.0855 10.3767 29.0418 10.5154 28.9999 10.6551C28.958 10.5154 28.9143 10.3767 28.8688 10.2396C28.4888 9.09639 27.9481 7.96296 27.1499 7.15774L27.1468 7.15462C25.9378 5.94559 24.298 5.26636 22.5882 5.26636C20.8783 5.26636 19.2385 5.94559 18.0295 7.15462C16.8205 8.36366 16.1412 10.0035 16.1412 11.7133C16.1412 13.4231 16.8205 15.0629 18.0295 16.272L18.7366 15.5649L18.0326 16.2751C18.3589 16.5985 18.7391 16.8797 19.152 17.125H9.0625C7.5092 17.125 6.25 18.3842 6.25 19.9375V27.1875C6.25 28.7408 7.5092 30 9.0625 30H9.875V45.3125C9.875 46.0584 10.1713 46.7738 10.6988 47.3012C11.2262 47.8287 11.9416 48.125 12.6875 48.125H29H45.3125C46.0584 48.125 46.7738 47.8287 47.3012 47.3012C47.8287 46.7738 48.125 46.0584 48.125 45.3125V30H48.9375C50.4908 30 51.75 28.7408 51.75 27.1875V19.9375C51.75 18.3842 50.4908 17.125 48.9375 17.125H38.8479C39.2608 16.8797 39.641 16.5985 39.9673 16.2751L39.2633 15.5649ZM9.0625 19.125C8.61377 19.125 8.25 19.4888 8.25 19.9375V27.1875C8.25 27.6362 8.61377 28 9.0625 28H10.875H28V19.125H9.0625ZM30 19.125V28H47.125H48.9375C49.3862 28 49.75 27.6362 49.75 27.1875V19.9375C49.75 19.4888 49.3862 19.125 48.9375 19.125H30ZM28 30H11.875V45.3125C11.875 45.528 11.9606 45.7347 12.113 45.887C12.2653 46.0394 12.472 46.125 12.6875 46.125H28V30ZM30 46.125V30H46.125V45.3125C46.125 45.528 46.0394 45.7347 45.887 45.887C45.7347 46.0394 45.528 46.125 45.3125 46.125H30ZM21.7452 16.096C20.723 15.7562 19.9284 15.3374 19.4421 14.8562C18.6091 14.0223 18.1412 12.8919 18.1412 11.7133C18.1412 10.5339 18.6097 9.4028 19.4437 8.56883C20.2777 7.73487 21.4088 7.26636 22.5882 7.26636C23.7668 7.26636 24.8972 7.73428 25.731 8.56725C26.2123 9.05357 26.6311 9.84816 26.9708 10.8704C27.3053 11.8767 27.5346 13.0152 27.6899 14.1032C27.8445 15.1872 27.9223 16.197 27.9613 16.9371C27.9641 16.991 27.9667 17.0434 27.9691 17.0943C27.9183 17.0918 27.8659 17.0892 27.812 17.0864C27.0719 17.0475 26.0621 16.9697 24.978 16.815C23.89 16.6598 22.7516 16.4304 21.7452 16.096Z"
                      fill="currentColor" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M32.2689 8.56722C31.7876 9.05354 31.3688 9.84814 31.029 10.8704C30.6946 11.8767 30.4652 13.0152 30.31 14.1032C30.1553 15.1872 30.0776 16.197 30.0386 16.9371C30.0358 16.991 30.0332 17.0434 30.0307 17.0943C30.0816 17.0918 30.134 17.0892 30.1879 17.0864C30.928 17.0475 31.9378 16.9697 33.0218 16.815C34.1098 16.6598 35.2483 16.4304 36.2546 16.096C37.2769 15.7562 38.0715 15.3374 38.5578 14.8561C39.3907 14.0223 39.8587 12.8919 39.8587 11.7133C39.8587 10.5339 39.3901 9.4028 38.5562 8.56883C37.7222 7.73487 36.5911 7.26636 35.4117 7.26636C34.2331 7.26636 33.1027 7.73427 32.2689 8.56722ZM39.2633 15.5649L39.9704 16.272C41.1794 15.0629 41.8587 13.4231 41.8587 11.7133C41.8587 10.0035 41.1794 8.36365 39.9704 7.15462C38.7614 5.94559 37.1216 5.26636 35.4117 5.26636C33.7019 5.26636 32.0621 5.94559 30.853 7.15461L30.8499 7.15774C30.0518 7.96296 29.5111 9.09639 29.1311 10.2396C29.0855 10.3767 29.0418 10.5154 28.9999 10.6551C28.958 10.5154 28.9143 10.3767 28.8688 10.2396C28.4888 9.09639 27.9481 7.96296 27.1499 7.15774L27.1468 7.15462C25.9378 5.94559 24.298 5.26636 22.5882 5.26636C20.8783 5.26636 19.2385 5.94559 18.0295 7.15462C16.8205 8.36366 16.1412 10.0035 16.1412 11.7133C16.1412 13.4231 16.8205 15.0629 18.0295 16.272L18.7366 15.5649L18.0326 16.2751C18.3589 16.5985 18.7391 16.8797 19.152 17.125H9.0625C7.5092 17.125 6.25 18.3842 6.25 19.9375V27.1875C6.25 28.7408 7.5092 30 9.0625 30H9.875V45.3125C9.875 46.0584 10.1713 46.7738 10.6988 47.3012C11.2262 47.8287 11.9416 48.125 12.6875 48.125H29H45.3125C46.0584 48.125 46.7738 47.8287 47.3012 47.3012C47.8287 46.7738 48.125 46.0584 48.125 45.3125V30H48.9375C50.4908 30 51.75 28.7408 51.75 27.1875V19.9375C51.75 18.3842 50.4908 17.125 48.9375 17.125H38.8479C39.2608 16.8797 39.641 16.5985 39.9673 16.2751L39.2633 15.5649ZM9.0625 19.125C8.61377 19.125 8.25 19.4888 8.25 19.9375V27.1875C8.25 27.6362 8.61377 28 9.0625 28H10.875H28V19.125H9.0625ZM30 19.125V28H47.125H48.9375C49.3862 28 49.75 27.6362 49.75 27.1875V19.9375C49.75 19.4888 49.3862 19.125 48.9375 19.125H30ZM28 30H11.875V45.3125C11.875 45.528 11.9606 45.7347 12.113 45.887C12.2653 46.0394 12.472 46.125 12.6875 46.125H28V30ZM30 46.125V30H46.125V45.3125C46.125 45.528 46.0394 45.7347 45.887 45.887C45.7347 46.0394 45.528 46.125 45.3125 46.125H30ZM21.7452 16.096C20.723 15.7562 19.9284 15.3374 19.4421 14.8562C18.6091 14.0223 18.1412 12.8919 18.1412 11.7133C18.1412 10.5339 18.6097 9.4028 19.4437 8.56883C20.2777 7.73487 21.4088 7.26636 22.5882 7.26636C23.7668 7.26636 24.8972 7.73428 25.731 8.56725C26.2123 9.05357 26.6311 9.84816 26.9708 10.8704C27.3053 11.8767 27.5346 13.0152 27.6899 14.1032C27.8445 15.1872 27.9223 16.197 27.9613 16.9371C27.9641 16.991 27.9667 17.0434 27.9691 17.0943C27.9183 17.0918 27.8659 17.0892 27.812 17.0864C27.0719 17.0475 26.0621 16.9697 24.978 16.815C23.89 16.6598 22.7516 16.4304 21.7452 16.096Z"
                      fill="white" fill-opacity="0.2" />
                    <g opacity="0.2">
                      <path
                        d="M47.125 29V45.3125C47.125 45.7932 46.934 46.2542 46.5941 46.5941C46.2542 46.934 45.7932 47.125 45.3125 47.125H12.6875C12.2068 47.125 11.7458 46.934 11.4059 46.5941C11.066 46.2542 10.875 45.7932 10.875 45.3125V29H47.125Z"
                        fill="currentColor" />
                      <path
                        d="M47.125 29V45.3125C47.125 45.7932 46.934 46.2542 46.5941 46.5941C46.2542 46.934 45.7932 47.125 45.3125 47.125H12.6875C12.2068 47.125 11.7458 46.934 11.4059 46.5941C11.066 46.2542 10.875 45.7932 10.875 45.3125V29H47.125Z"
                        fill="white" fill-opacity="0.2" />
                    </g>
                  </svg>
                  <h5 class="my-3">Progress Tracking</h5>
                  <p class="mb-3">Shows completion status and performance metrics in real-time.</p>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-md-6">
              <div class="card border shadow-none">
                <div class="card-body text-center">
                  <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g opacity="0.2">
                      <path
                        d="M50.6367 12.6875H7.36328C6.2997 12.6875 5.4375 13.5497 5.4375 14.6133V43.3867C5.4375 44.4503 6.2997 45.3125 7.36328 45.3125H50.6367C51.7003 45.3125 52.5625 44.4503 52.5625 43.3867V14.6133C52.5625 13.5497 51.7003 12.6875 50.6367 12.6875Z"
                        fill="currentColor" />
                      <path
                        d="M50.6367 12.6875H7.36328C6.2997 12.6875 5.4375 13.5497 5.4375 14.6133V43.3867C5.4375 44.4503 6.2997 45.3125 7.36328 45.3125H50.6367C51.7003 45.3125 52.5625 44.4503 52.5625 43.3867V14.6133C52.5625 13.5497 51.7003 12.6875 50.6367 12.6875Z"
                        fill="white" fill-opacity="0.2" />
                    </g>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M6.6875 14.6133C6.6875 14.2401 6.99006 13.9375 7.36328 13.9375H50.6367C51.0099 13.9375 51.3125 14.2401 51.3125 14.6133V43.3867C51.3125 43.7599 51.0099 44.0625 50.6367 44.0625H7.36328C6.99006 44.0625 6.6875 43.7599 6.6875 43.3867V14.6133ZM7.36328 11.4375C5.60935 11.4375 4.1875 12.8593 4.1875 14.6133V43.3867C4.1875 45.1407 5.60935 46.5625 7.36328 46.5625H50.6367C52.3907 46.5625 53.8125 45.1407 53.8125 43.3867V14.6133C53.8125 12.8593 52.3907 11.4375 50.6367 11.4375H7.36328ZM12.6875 20.75C12.1352 20.75 11.6875 21.1977 11.6875 21.75C11.6875 22.3023 12.1352 22.75 12.6875 22.75H45.3125C45.8648 22.75 46.3125 22.3023 46.3125 21.75C46.3125 21.1977 45.8648 20.75 45.3125 20.75H12.6875ZM12.6875 28C12.1352 28 11.6875 28.4477 11.6875 29C11.6875 29.5523 12.1352 30 12.6875 30H45.3125C45.8648 30 46.3125 29.5523 46.3125 29C46.3125 28.4477 45.8648 28 45.3125 28H12.6875ZM11.6875 36.25C11.6875 35.6977 12.1352 35.25 12.6875 35.25H14.5C15.0523 35.25 15.5 35.6977 15.5 36.25C15.5 36.8023 15.0523 37.25 14.5 37.25H12.6875C12.1352 37.25 11.6875 36.8023 11.6875 36.25ZM21.75 35.25C21.1977 35.25 20.75 35.6977 20.75 36.25C20.75 36.8023 21.1977 37.25 21.75 37.25H36.25C36.8023 37.25 37.25 36.8023 37.25 36.25C37.25 35.6977 36.8023 35.25 36.25 35.25H21.75ZM42.5 36.25C42.5 35.6977 42.9477 35.25 43.5 35.25H45.3125C45.8648 35.25 46.3125 35.6977 46.3125 36.25C46.3125 36.8023 45.8648 37.25 45.3125 37.25H43.5C42.9477 37.25 42.5 36.8023 42.5 36.25Z"
                      fill="currentColor" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M6.6875 14.6133C6.6875 14.2401 6.99006 13.9375 7.36328 13.9375H50.6367C51.0099 13.9375 51.3125 14.2401 51.3125 14.6133V43.3867C51.3125 43.7599 51.0099 44.0625 50.6367 44.0625H7.36328C6.99006 44.0625 6.6875 43.7599 6.6875 43.3867V14.6133ZM7.36328 11.4375C5.60935 11.4375 4.1875 12.8593 4.1875 14.6133V43.3867C4.1875 45.1407 5.60935 46.5625 7.36328 46.5625H50.6367C52.3907 46.5625 53.8125 45.1407 53.8125 43.3867V14.6133C53.8125 12.8593 52.3907 11.4375 50.6367 11.4375H7.36328ZM12.6875 20.75C12.1352 20.75 11.6875 21.1977 11.6875 21.75C11.6875 22.3023 12.1352 22.75 12.6875 22.75H45.3125C45.8648 22.75 46.3125 22.3023 46.3125 21.75C46.3125 21.1977 45.8648 20.75 45.3125 20.75H12.6875ZM12.6875 28C12.1352 28 11.6875 28.4477 11.6875 29C11.6875 29.5523 12.1352 30 12.6875 30H45.3125C45.8648 30 46.3125 29.5523 46.3125 29C46.3125 28.4477 45.8648 28 45.3125 28H12.6875ZM11.6875 36.25C11.6875 35.6977 12.1352 35.25 12.6875 35.25H14.5C15.0523 35.25 15.5 35.6977 15.5 36.25C15.5 36.8023 15.0523 37.25 14.5 37.25H12.6875C12.1352 37.25 11.6875 36.8023 11.6875 36.25ZM21.75 35.25C21.1977 35.25 20.75 35.6977 20.75 36.25C20.75 36.8023 21.1977 37.25 21.75 37.25H36.25C36.8023 37.25 37.25 36.8023 37.25 36.25C37.25 35.6977 36.8023 35.25 36.25 35.25H21.75ZM42.5 36.25C42.5 35.6977 42.9477 35.25 43.5 35.25H45.3125C45.8648 35.25 46.3125 35.6977 46.3125 36.25C46.3125 36.8023 45.8648 37.25 45.3125 37.25H43.5C42.9477 37.25 42.5 36.8023 42.5 36.25Z"
                      fill="white" fill-opacity="0.2" />
                  </svg>
                  <h5 class="my-3">Feedback & Results</h5>
                  <p class="mb-3">Provides access to scores, feedback, and improvement suggestions after completion.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Popular Articles: End -->
  <!-- / Sections:End -->
  <!-- Footer: Start -->
  <footer class="landing-footer bg-body footer-text">
    <div class="footer-top position-relative overflow-hidden z-1">
      <img src="{{ asset('admin/assets/img/pages/footer-bg.png') }}" alt="footer bg"
        class="footer-bg banner-bg-img z-n1" />
      <div class="container">
        <div class="row gx-0 gy-6 g-lg-10">
          <div class="col-lg-5">
            <a href="#" class="app-brand-link mb-6">
              <img style="width: 140px;" src="{{ asset('admin/assets/img/avatars/superior.svg') }}">
            </a>
            <p class="footer-text footer-logo-description mb-6">To make Pakistan economically Superior by providing
              services in education, healthcare media, technology and scaling up enterprises both nationally and
              internationally thus adding value to our nation and ultimately to humanity. May Allah Almighty Help Us</p>
          </div>

        </div>
      </div>
    </div>
    <div class="footer-bottom py-3 py-md-5">
      <div class="container d-flex flex-wrap justify-content-between flex-md-row flex-column text-center text-md-start">
        <div class="mb-2 mb-md-0">
          <span class="footer-bottom-text">©
            <script>
              document.write(new Date().getFullYear());
            </script>
          </span>
          <a href="/" target="_blank" class="fw-medium text-white">Superior</a>
        </div>
        <div>
        </div>
      </div>
    </div>
  </footer>
  <!-- Footer: End -->
  <script src="{{ asset('admin/assets/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/@algolia/autocomplete-js.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/pickr/pickr.js') }}"></script>
  <script src="{{ asset('admin/assets/js/front-main.js') }}"></script>

</body>

</html>