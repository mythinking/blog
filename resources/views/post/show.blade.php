@extends('index')

@section('content')
<div id="container">
    <div id="post-list">
        <div class="post" id="{{ $post->post_id }}">
            <div class="post-header">
                <h2 class="text-center">{{ $post->post_title }}</h2>
                {{--<div class="post-date">
                    <a href="/category/date/{{ substr($post->post_date,0,10) }}">{{ substr($post->post_date,0,10) }}</a>
                </div>
                <div class="post-tag">
                    @foreach ($post->tags as $tag)
                    <a href="/tags/{{ $tag }}">#{{ $tag }}</a>
                    @endforeach
                </div>--}}
            </div>
            <div class="post-content"><?php echo $post->post_content; ?></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('document').ready(function(){
        var html = marked($('.post-content').html());
        console.log(html);
        $('.post-content').html(html);
    });
</script>
@endsection