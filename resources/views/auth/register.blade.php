@extends('index')

@section('content')
<div id="register" class="text-center">
    <div class="ui form segment">
        <div class="text text-greensea">
            <h2>注册新账号</h2>
        </div>

        <form role="form" method="POST" action="/auth/register">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="required field">
                <div class="ui labeled input">
                    <a class="ui label">姓名</a>
                    <input type="text" class="form-control" name="name" placeholder="姓名" value="{{ old('name') }}">
                </div>
            </div>

            <div class="required field">
                <div class="ui labeled input">
                    <a class="ui label">邮箱</a>
                    <input type="email" class="form-control" name="email" placeholder="邮箱" value="{{ old('email') }}">
                </div>
            </div>

            <div class="required field">
                <div class="ui labeled input">
                    <a class="ui label green">密码</a>
                    <input type="password" class="form-control" placeholder="密码" name="password">
                </div>
            </div>

            <div class="required field">
                <div class="ui labeled input">
                    <a class="ui label">确认</a>
                    <input type="password" class="form-control" placeholder="确认密码" name="password_confirmation">
                </div>
            </div>

            <div id="submit">
                <button class="ui green submit button" type="submit">立即注册</button></div>
        </form>
    </div>
</div>
@endsection
