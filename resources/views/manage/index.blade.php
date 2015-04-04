@extends('index')

@section('content')
    <div id="container" class="manage" style="border-radius: 0;">
        <div id="manage-container">
            <div class="ui secondary pointing filter menu">
                {{--@if (Route::current()->getUri() == 'manage')
                    <a class="black item active" data-tab="index" href="/manage">概述</a>
                @else
                    <a class="black item" data-tab="index" href="/manage">概述</a>
                @endif--}}

                    @if (Route::current()->getUri() == 'manage'
                        || Route::current()->getUri() == 'manage/posts'
                        || Route::current()->getUri() == 'post/create'
                        || Route::current()->getUri() == 'manage/posts/edit')
                        <a class="red item active" data-tab="posts" href="/manage/posts">文章</a>
                    @else
                        <a class="red item" data-tab="posts" href="/manage/posts">文章</a>
                    @endif

                    @if (Route::current()->getUri() == 'manage/setting')
                        <a class="green item active" data-tab="setting" href="/manage/setting">配置</a>
                    @else
                        <a class="green item" data-tab="setting" href="/manage/setting">配置</a>
                    @endif

                    @if (Route::current()->getUri() == 'manage/user')
                        <a class="blue item active" data-tab="user" href="/manage/user">用户</a>
                    @else
                        <a class="blue item" data-tab="user" href="/manage/user">用户</a>
                    @endif
            </div>
            @yield('manage-main')
        </div>
    </div>
@endsection