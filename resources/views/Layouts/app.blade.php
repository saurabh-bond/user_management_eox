<!doctype html>
<html lang="en">
<head>

    @include('layouts.header')

    <title>
        @yield('title')

    </title>
</head>
<body>

<body>
@include('layouts.navbar')
@section('sidebar')

@show

<div class="container">
    @yield('content')
</div>

@include('layouts.footer')


</body>

</html>
