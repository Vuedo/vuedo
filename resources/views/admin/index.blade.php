<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard - Vue.js Feed</title>
    <link rel="shortcut icon" href="{{ config('website.icon') }}">
    <!-- Fonts -->
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="/lte/css/bootstrap.min.css">
    <!-- Pnotify -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.0.0/pnotify.css">
    <link rel="stylesheet" href="/css/pnotify.buttons.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Sweetalert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/sweetalert2/4.0.5/sweetalert2.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/lte/css/AdminLTE.css">
    <link rel="stylesheet" href="/lte/css/skin-blue.min.css">

</head>
<body class="skin-blue sidebar-mini">
<script>
    {{--TODO: Remove else when check is done with middleware--}}
    @if(Auth::user())
        const User = {!! Fractal::includes(['role'])->item(Auth::user(), new \App\Transformers\UserTransformer)->getJson() !!};
        User.isAdmin = {{ Auth::user()->isAdmin() }};
    @else
        const User = {isAdmin: false}
    @endif
</script>

{{-- jQuery --}}
<script src="/lte/js/jQuery-2.2.0.min.js"></script>
{{-- pnotify --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.0.0/pnotify.js"></script>
<script src="/js/pnotify.buttons.js"></script>
{{-- Sweetalert --}}
<script src="https://cdn.jsdelivr.net/sweetalert2/4.0.5/sweetalert2.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/lte/js/bootstrap.min.js"></script>
{{-- AdminLTE js --}}
<script src="/lte/js/app.min.js"></script>
<!-- JavaScripts -->
<script src="{{'/js/main.js'}}"></script>

<!-- Live Reload -->
@if ( Config::get('app.debug') )
    <script type="text/javascript">
        document.write('<script src="//localhost:35729/livereload.js?snipver=1" type="text/javascript"><\/script>')
    </script>
@endif
</body>
</html>

