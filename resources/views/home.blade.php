@extends('index')

@section('content')
<div id="container">
    <div id="post-list">
        @foreach($posts as $post)
        <div class="post" id="post-{{ $post->post_id }}}">
            <div class="post-header">
                <h2><a href="/post/{{ $post->post_id }}">{{ $post->post_title }}</a></h2>
                <div class="post-date">
                    <a href="/category/date/<?php echo date('Y-m-d',strtotime($post->post_date)); ?>"><?php echo date('Y-m-d',strtotime($post->post_date)); ?></a>
                </div>
                <div class="post-tag">
                    @foreach($post->tags as $tag)
                        <a href="/category/tags/{{ $tag->term_id }}"> #{{ $tag->name }} </a>
                    @endforeach
                </div>
            </div>
            <div class="post-content"><?php echo mb_substr($post->post_content,0,500)."..."; ?><a href="/post/{{ $post->post_id }}"><b>阅读全文</b></a></div>
        </div>
        @endforeach

        <div class="pager">
            <!--上一页-->
            @if(!empty($pager['prev']))
                <a class="ui tiny basic button left" href="/manage/posts?page={{ $pager['prev'] }}">上一页</a>
            @endif
            <!--下一页-->
            @if(!empty($pager['next']))
                <a class="ui tiny basic button right" href="/manage/posts?page={{ $pager['next'] }}">下一页</a>
            @endif
        </div>

    </div>
    <script type="text/javascript">
        $('document').ready(function(){
            $('.post-content').each(function(){
                html = marked($(this).html());
                $(this).html(html);
            });
        });
    </script>
</div>
@endsection