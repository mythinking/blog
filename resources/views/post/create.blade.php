@extends('manage/index')

@section('manage-main')
<div id="manage-main">
    <a class="ui green tiny button" href="/manage/posts">返回列表</a>
    <div id="post-form" class="ui form segment">
        <div class="ui positive message disable">
            <i class="close icon"></i>
            <div class="header">
            </div>
        </div>
        <div id="post-form-content">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <input type="hidden" name="post_id" id="post_id" value="@if(isset($post->post_id)) {{ $post->post_id }} @endif">
            <div class="required field">
                <div class="ui labeled input">
                    <a class="ui label" style="width: 10%;text-align:right">文章标题</a>
                    <input type="text" name="title" id="title" value="@if(isset($post->post_title)) {{ $post->post_title }} @endif" placeholder="typed the title in here">
                </div>
            </div>

            <div class="required field">
                <div class="ui labeled input">
                    <a class="ui label" style="width: 10%;text-align:right">标签</a>
                    <input type="text" name="tag" id="tag" value="@if(isset($post->tags)) {{ $post->tags }} @endif" placeholder="多标签用#隔开">
                </div>
            </div>

            <div class="required field">
                <textarea name="content" class="textarea" id="content">
                    @if(isset($post->post_content))
                        {{ $post->post_content }}
                    @endif
                </textarea>
            </div>

            <div class="field left">
                <div class="ui toggle checkbox">
                    <label>开启评论?</label>
                    <input type="radio" checked="checked" id="comment-status" name="comment_status">
                </div>

                <div class="ui toggle checkbox">
                    <label>是页面？</label>
                    <input type="radio" name="is_page" id="is-page">
                </div>
            </div>

            <div class="right">
                <button class="ui button red" type="button" id="publish">发布</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#title').on('keyup',function(){
        if($('#title').val() != ''){
            $('#title').parent().parent().removeClass('error');
        }
    });
    $('#content').on('keyup',function(){
        if($('#content').val() != ''){
            $('#content').parent().removeClass('error');
        }
    });

    $('#publish').on('click',function(){
        var postId = $.trim($('#post_id').val());
        var token = $.trim($('#token').val());
        var title = $.trim($('#title').val());
        var tag = $.trim($('#tag').val());
        var content = $.trim($('#content').val());
        var commentStats = $.trim($('#comment-status').val());
        var isPage = $.trim($('#is-page').val());

        if(title == ''){
            $('#title').parent().parent().addClass('error');
            return;
        }
        if(content == ''){
            $('#content').parent().addClass('error');
            return;
        }

        $.ajax({
            url:postId == '' ? '/post/store' : '/manage/posts/update',
            data:{
                "postId":postId,
                "_token":token,
                "title":title,
                "content":content,
                "tag":tag,
                "commentStatus":commentStats,
                "isPage":isPage
            },
            type:'post',
            success:function(data){
                if(data >= 1){
                    var html = '添加文章成功,<a href="/post/'+data+'" target="_blank">点击这里查看</a>';
                    $('#post-form .message .header').html(html);
                    $('#post-form .message').removeClass('disable');
                }
            }
        });
    });
</script>
@endsection