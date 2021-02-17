<!DOCTYPE html>
<html class="no-js" lang="">
    <head>
        @include('frontend.general.head')
    </head>
    <body>
        @include('frontend.general.menu')
        @yield('content')
        @include('frontend.general.footer')
        @yield('js')
    </body>
</html>