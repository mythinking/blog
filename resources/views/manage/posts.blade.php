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
                <tr>
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
                        <button class="ui button blue tiny">编 辑</button>
                        <button class="ui button red tiny">删 除</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <!--上一页-->
        @if(!empty($pager['prev']))
            <a class="ui tiny basic button" href="/manage/posts?page={{ $pager['prev'] }}">上一页</a>
        @endif
        <!--下一页-->
        @if(!empty($pager['next']))
            <a class="ui tiny basic button" href="/manage/posts?page={{ $pager['next'] }}">下一页</a>
        @endif
    </div>
@endsection