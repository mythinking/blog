@extends('index')

@section('content')
    <div id="container" style="border-radius: 0;">
        <div id="manage-container">
            <div id="manage-sidebar">
                <div class="ui secondary vertical menu">
                    <a class="active item">
                        <i class="users icon"></i>
                        Friends
                    </a>
                    <a class="item">
                        <i class="mail icon"></i> Messages
                    </a>
                    <a class="item">
                        <i class="user icon"></i> Friends
                    </a>
                </div>
            </div>
            @yield('manage-main')
        </div>
    </div>
@endsection