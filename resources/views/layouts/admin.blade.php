<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, maximum-scale=1">
    <title>{{$title}}</title>
    <link rel="icon" href="{{asset('assets/favicon.png')}}" type="image/png">
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="{{asset('assets/js/jquery-1.11.0.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/bootstrap-filestyle-2.1.0/src/bootstrap-filestyle.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/bootstrap-filestyle-2.1.0/src/bootstrap-filestyle.min.js')}}"></script>
</head>
<body>

<header id="header_wrapper">
 @yield('header')

    @if(count($errors)>0)
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $item)
                <li>{{$item}}</li>
            @endforeach
        </ul>
    </div>
@endif
    @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
@endif
</header>
 @yield('content')
</body>
</html>





</body>
</html>