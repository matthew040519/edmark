<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta19
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Edmark</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <script defer data-api="/stats/api/event" data-domain="preview.tabler.io" src="/stats/js/script.js"></script> -->
    <meta name="msapplication-TileColor" content=""/>
    <meta name="theme-color" content=""/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="HandheldFriendly" content="True"/>
    <meta name="MobileOptimized" content="320"/>
    <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon"/>
    <meta name="description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!"/>
    <meta name="canonical" content="https://preview.tabler.io/">
    <meta name="twitter:image:src" content="https://preview.tabler.io/static/og.png">
    <meta name="twitter:site" content="@tabler_ui">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Tabler: Premium and Open Source dashboard template with responsive and high quality UI.">
    <meta name="twitter:description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!">
    <meta property="og:image" content="https://preview.tabler.io/static/og.png">
    <meta property="og:image:width" content="1280">
    <meta property="og:image:height" content="640">
    <meta property="og:site_name" content="Tabler">
    <meta property="og:type" content="object">
    <meta property="og:title" content="Tabler: Premium and Open Source dashboard template with responsive and high quality UI.">
    <meta property="og:url" content="https://preview.tabler.io/static/og.png">
    <meta property="og:description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!">
    <!-- CSS files -->
    <link href="./dist/css/tabler.min.css?1685973381" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css?1685973381" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css?1685973381" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css?1685973381" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css?1685973381" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.7.0.js" type="text/javascript"></script>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
    <style type="text/css">
      /*footer {
          position: fixed;
          height: 70px;
          bottom: 0;
          width: 100%;
      }*/
    </style>
  </head>
  <body >
    <script src="./dist/js/demo-theme.min.js?1685973381"></script>
    <!-- <div class="page page-center">
      <div class="container container-slim py-4">
        <div class="text-center">
          <div class="mb-3">
            <a href="." class="navbar-brand navbar-brand-autodark"><img src="./static/logo-small.svg" height="36" alt=""></a>
          </div>
          <div class="text-secondary mb-3">Preparing application</div>
          <div class="progress progress-sm">
            <div class="progress-bar progress-bar-indeterminate"></div>
          </div>
        </div>
      </div>
    </div> -->
    @yield('content')
    <!-- Libs JS -->
    <!-- <script src="./dist/libs/apexcharts/dist/apexcharts.min.js?1685973381" defer></script>
    <script src="./dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1685973381" defer></script>
    <script src="./dist/libs/jsvectormap/dist/maps/world.js?1685973381" defer></script>
    <script src="./dist/libs/jsvectormap/dist/maps/world-merc.js?1685973381" defer></script> -->
    <!-- Tabler Core -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer><  /script> -->
    <script src="./dist/js/tabler.min.js?1685973381" defer></script>
    <script src="./dist/js/demo.min.js?1685973381" defer></script>
     
    
  </body>
</html>