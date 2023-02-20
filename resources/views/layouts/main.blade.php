<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <link rel="stylesheet" href="{{ url('css/main.css?v=1628755089081')}}">
  <link rel="stylesheet" href="{{ url('https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css')}}">
  <script src="{{ url('//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js') }}"></script>
  <script src="{{ url('//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css') }}"></script>
  <script src="{{ url('http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}"></script>
  <script src="{{ url('https://code.jquery.com/jquery-3.6.0.min.js') }}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
    @include('layouts.header')
<body class="bg-slate-200">
    @include('layouts.sidebar')
    <div style="padding: 1rem">
      @yield('container')
    </div>
</body>


<script src="{{ url('https://cdn.tailwindcss.com') }}"></script>
<script type="text/javascript" src="{{ url('js/main.min.js?v=1628755089081')}}"></script>
</html>