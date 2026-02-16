<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-assets-path="{{ asset('admin/assets') }}/"
  data-template="vertical-menu-template" class="layout-navbar-fixed layout-menu-fixed layout-compact one"
  data-skin="default" data-bs-theme="light" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel1') }}</title>

  <link rel="icon" type="image/x-icon"
    href="https://demos.pixinvent.com/vuexy-html-admin-template/assets/img/favicon/favicon.ico" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com/" />
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;ampdisplay=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/iconify-icons.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/fontawesome.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/node-waves/node-waves.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/pickr/pickr-themes.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/core.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/css/chatbot.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
  @stack('style')
  <script src="{{ asset('admin/assets/vendor/js/helpers.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/js/template-customizer.js') }}"></script>
  <script src="{{ asset('admin/assets/js/config.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .bg-ni {
      background-color: #fd7e13 !important;
      color: white;
    }
  </style>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar  ">
    <div class="layout-container">
      <!-- Menu -->
      @if(activeRole() === 'survey')
        @include('layouts.survey_sidebar')
      @elseif(activeRole() === 'teacher')
        @include('layouts.teacher_sidebar')
      @elseif(activeRole() === 'professor')
        @include('layouts.teacher_sidebar')
      @elseif(activeRole() === 'assistant professor')
        @include('layouts.teacher_sidebar')
      @elseif(activeRole() === 'associate professor')
        @include('layouts.teacher_sidebar')
      @elseif(activeRole() === 'program leader ug')
        @include('layouts.teacher_sidebar')
      @elseif(activeRole() === 'program leader pg')
        @include('layouts.teacher_sidebar')
      @elseif(activeRole() === 'hod')
        @include('layouts.hod_sidebar')
      @elseif(activeRole() === 'dean')
        @include('layouts.dean_sidebar')
      @elseif(activeRole() === 'rector')
        @include('layouts.rector_sidebar')
      @elseif(activeRole() === 'oric')
        @include('layouts.oric_sidebar')
      @else
        @include('layouts.sidebar')
      @endif
      @include('partials.celebration')
      <!-- / Menu -->
      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- / Navbar -->
        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
          @yield('content')
          <!-- / Content -->
          <!-- Footer -->
          @include('layouts.footer')
          <!-- / Footer -->
          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

  </div>
  <!-- / Layout wrapper -->
  <!--chat bot-->
  {{-- <div class="assessment_chatbot">
    <button class="chatbot-toggler">
      <span class="icon-base ti tabler-message">mode_comment</span>
      <span class="icon-base ti tabler-x">close</span>
    </button>
    <div class="chatbot">
      <header>
        <h2>Chatbot</h2>
        <span class="close-btn icon-base ti tabler-x"></span>
      </header>
      <ul class="chatbox">
        <li class="chat incoming">
          <span class="icon-base ti tabler-user"></span>
          <p>Hi there <br>How can I help you today?</p>
        </li>
      </ul>
      <div class="chat-input">
        <textarea placeholder="Enter a message..." spellcheck="false" required></textarea>
        <span id="send-btn" class="menu-icon icon-base ti tabler-send-2">send</span>
      </div>
    </div>
  </div> --}}
  <!-- / chat bot -->
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
  @stack('script')
  <script src="{{ asset('admin/assets/js/main.js') }}"></script>
  <script src="{{ asset('admin/assets/js/chat-bot.js') }}"></script>
</body>

</html>