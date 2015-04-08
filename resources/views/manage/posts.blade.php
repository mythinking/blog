@extends('manage/index')

@section('manage-main')
    <div id="manage-main">
    	<a class="ui tiny green button" href="/post/create">新文章</a>

        <table class="ui very basic table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>标题</th>
                    <th>发布时间</th>
                    <th>标签</th>
                    <th>发布状态</th>
                    <th>评论总数</th>
                    <th>文章类型</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($posts as $line)
                <tr id="tr-{{ $line->post_id }}">
                    <td>{{ $line->post_id }}</td>
                    <td><a href="/post/{{ $line->post_id }}" target="_blank">{{ $line->post_title }}</a></td>
                    <td>{{ $line->post_date }}</td>
                    <td>
                        @foreach($line->tags as $tag)
                            <label class="ui label tiny red">
                                {{ $tag->name }}
                            </label>
                        @endforeach
                    </td>

                    <td>{{ $line->post_status }}</td>
                    <td>{{ $line->comment_count }}</td>
                    <td>
                        <label class="ui label green tiny">
                        @if($line->is_page == 1)
                            文章
                        @else
                            页面
                        @endif
                        </label>
                    </td>
                    <td>
                        <a class="ui button blue tiny update" href="/manage/posts/edit/{{ $line->post_id }}">编 辑</a>
                        <button class="ui button red tiny delete" data-post-id="{{ $line->post_id }}">删 除</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pager text-center">
            <!--上一页-->
            @if(!empty($pager['prev']))
                <a class="ui tiny basic button" href="/manage/posts/{{ $pager['prev'] }}">上一页</a>
            @endif
            <!--下一页-->
            @if(!empty($pager['next']))
                <a class="ui tiny basic button" href="/manage/posts/{{ $pager['next'] }}">下一页</a>
            @endif
        </div>
    </div>
    <script type="text/javascript">
        //删除
        $('.delete').click(function(){
            var obj = $(this);
            var postId = obj.attr('data-post-id');

            $.ajax({
                type:'get',
                url:'/manage/posts/delete?id='+postId,
                success: function (data) {
                    if(data == 1){
                        alert('删除成功啦^_^');
                        $('#tr-'+postId).remove();
                    }else{
                        alert('删除失败T_T');
                    }
                }
            });
        });
    </script>
@endsection