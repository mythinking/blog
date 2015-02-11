@extends('index')

@section('content')
<div id="register" class="text-center">
    <div class="ui form segment">
        <div class="text text-greensea">
            <h2>欢迎登录</h2>
        </div>

        <form class="form-horizontal" role="form" method="POST" action="/auth/login">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="required field">
                <div class="ui labeled input">
                    <a class="ui label green">邮箱</a>
                    <input type="email" id="email" name="email" placeholder="邮箱">
                </div>
            </div>
            <div class="required field">
                <div class="ui labeled input">
                    <a class="ui label green">密码</a>
                    <input type="password" id="password" name="password" placeholder="登录密码">
                </div>
            </div>
            <div id="submit">
                <button class="ui blue submit button" type="submit">立即登录</button></div>
        </form>
    </div>
</div>
@endsection
