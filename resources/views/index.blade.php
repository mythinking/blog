<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>The Laravel 5.0 Blog</title>

    <link rel="stylesheet" type="text/css" href="/css/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" href="http://libs.useso.com/js/highlight.js/8.0/styles/googlecode.min.css">
    <script src="http://libs.useso.com/js/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://libs.useso.com/js/highlight.js/8.0/highlight.min.js"></script>
    <script src="/js/marked.min.js"></script>
    <script src="/js/semantic.min.js"></script>
    <script src="/js/common.js"></script>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![end if]-->
</head>
<body>
<div id="header">
    <div id="nav">
        <div id="menu" class="left">
            <a href="/" style="font-size: 25px;text-decoration: none;color: #ffffff">Laravel</a>
        </div>

        <div id="profile" class="right">
            @if (Auth::guest())
            <ul>
                <li><a href="/auth/login">登录</a></li>
                <li><a href="/auth/register">注册</a></li>
            </ul>
            @else
            <ul>
                <li><span>{{ Auth::user()->name }}</span></li>
                @if( Auth::user()->level >= 99)
                <li><a href="/management">管理</a></li>
                @endif
                <li><a href="/auth/logout">退出</a></li>
            </ul>
            @endif
        </div>
    </div>
</div>
@yield('content')
<div id="footer" class="text-center">
    <span class="copyright">&copy; 2014 Laravel-blog</span>
</div>

@if (Route::current()->getUri() == 'post/create')
<div id="fixed-right-tools" style="display:none">
@endif
<div id="fixed-right-tools">
    @if (!Auth::guest() && Auth::user()->level >= 9)
    <a id="new-post" class="background-icon" href="/post/create"></a>
    @endif
</div>
</body>
</html>