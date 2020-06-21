<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v3.0.0-alpha.1
* @link https://coreui.io
* Copyright (c) 2019 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->

<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CHOPNOW">
    <meta name="author" content="Kocots">
    <meta name="keyword" content="Chopnow Admin Panel - Access/Modify">
    <title>OrderAm</title>

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Main styles for this application-->

    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link href="{{ asset('css/u/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/u/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/u/component.css') }}" rel="stylesheet">
    <link href="{{ asset('css/u/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/v/custom.css') }}" rel="stylesheet">

    <script src="{{ asset('jquery/dist/jquery-2.2.2.min.js') }}"></script>
    <link href="{{ asset('css/pace.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.css') }}">

    @yield('css')

    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      // Shared ID
      gtag('config', 'UA-118965717-3');
      // Bootstrap ID
      gtag('config', 'UA-118965717-5');
    </script>
  </head>

  <body class="not-transparent-header">

    <div class="container-wrapper">

        @include('vendor.inc.header')

        <div class="main-wrapper">

            @yield('content')

            @include('vendor.inc.footer')
        </div>

    </div>

    <script type="text/javascript" src="{{ asset('js/u/jquery-migrate-1.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/bootstrap-modalmanager.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('js/u/bootstrap-modal.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('js/u/smoothscroll.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/jquery.easing.1.3.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/jquery.waypoints.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/jquery.slicknav.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/jquery.placeholder.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/bootstrap-tokenfield.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/typeahead.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/jquery-filestyle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/ion.rangeSlider.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/handlebars.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/jquery.countimator.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/jquery.countimator.wheel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/slick.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/easy-ticker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/jquery.introLoader.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/jquery.responsivegrid.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/u/customs.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/v/req.js') }}"></script>
    <script src="{{ asset('js/pace.js') }}"></script>

    <script>
      @if(Session::has('errors'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('errors') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('errors') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('errors') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('errors') }}");
                break;
        }
      @endif
    </script>

  </body>
</html>
