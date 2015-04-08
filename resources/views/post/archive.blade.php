@extends('index')

@section('content')
    <div id="container">
        <div id="post-list">
            @foreach($data as $item)
                <div class="post" id="post-{{ $item->post_id }}" style="margin: 10px 0px;">
                    <div class="post-header" style="margin: 10px 0px;">
                        <h3 style="display: inline-block"><a href="/post/{{ $item->post_id }}">{{ $item->post_title }}</a></h3>
                        <small style="font-size: 11px; color: #888;">{{ $item->post_date }}</small>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="pager text-center">
            <!--上一页-->
            @if(!empty($pager['prev']))
                <a class="ui tiny basic button " href="/archive/{{ $view }}/{{ $key }}/{{ $pager['prev'] }}">上一页</a>
                @endif
                        <!--下一页-->
                @if(!empty($pager['next']))
                    <a class="ui tiny basic button" href="/archive/{{ $view }}/{{ $key }}/{{ $pager['next'] }}">下一页</a>
                @endif
        </div>
    </div>
@endsection