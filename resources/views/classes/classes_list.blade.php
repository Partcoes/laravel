@extends('adminlte::page')
<style>
    tr,td,th{
        border: 1px solid #ccc !important;
        text-align: center !important;
    }
    td{
        width: 18% !important;
    }
    table{
        border: 1px solid #ccc !important;
        width: 80% !important;
        margin-left: 5% !important;
    }
    hr{
        border-bottom: 1px solid black !important;
    }
    .status_normal{
        color:green;
    }
    .status_stop{
        color:red;
    }
    #alone_head{
        margin-left: 5% !important;
        margin-bottom: 30px !important;
    }
</style>
@section('title', 'Dashboard')

@section('content_header')
    <h1>类型管理</h1>
    <hr/>
@stop

@section('content')
    <div id="parent" style="height:100%;position: relative !important;">
    <p id="alone_head">
        @if($alones)
            @foreach($alones as $k => $alone)
                <a href="/{{$alone -> button_url}}" class="btn {{$alone -> class}}">{{$alone -> button_name}}</a>
            @endforeach
        @endif
    </p>
    <table class="table table-active">
        <tr>
            <th>#</th>
            <th>类型名称</th>
            <th>状态</th>
            <th>属性个数</th>
            <th id="operate">操作</th>
        </tr>
        @foreach($classes as $k => $class)
            <tr id="num">
                <th><input type="checkbox" value="{{$class -> typeof_id}}"></th>
                <td>{{$class -> typeof_name}}</td>
                <th>@if($class -> typeof_status == 0)<span class="status_stop">停用</span>@elseif($class -> typeof_status == 1)<span class="status_normal">正常</span>@endif</th>
                <td>{{$class -> typeof_num}}</td>
                <th>
                    @if($buttons)
                        @foreach($buttons as $k => $button)
                            @if($button -> button_name == '删除' || $button -> button_name == '停用/启用')
                                <{{$button->code}} delete="delete"  status="{{$class -> typeof_status}}" alerturl="{{url($button -> button_url)}}?id={{$class -> typeof_id}}" class="btn {{$button -> class}}">{{$button -> button_name}}</{{$button -> code}}>
                            @else
                                <a href="{{url($button -> button_url)}}?id={{$class-> typeof_id}}" alerturl="{{url($button -> button_url)}}?id={{$class -> typeof_id}}" class="btn {{$button -> class}}">{{$button -> button_name}}</a>
                            @endif
                        @endforeach
                    @endif
                </th>
            </tr>
        @endforeach
    </table>
    <div style="position: absolute !important;left:40% !important;top:65%;">{{ $classes->links() }}</div>
    </div>
@stop

@section('css')

@stop

@section('js')
    <script>
        $(document).ready(function(){
            var num = $('#num').children().length;
            if(num <= 5){
                $('#operate').prop("style",'width:30% !important');
            }

        })
        $("button[delete='delete']").click(function(){
            var url = $(this).attr('alerturl');
            var obj = $(this);
            var status = obj.attr('status');
            if(status == 1){
                status = 0;
            }else{
                status = 1;
            }
            $.ajax({
                url:url,
                type:'get',
                data:{typeof_status:status},
                success:function(msg){
                    if(msg == 1) {
                        // obj.parents('tr').remove();
                        history.go(0);
                    }else{
                        console.log(msg);return;
                    }
                },
                error:function(msg){
                    var errorText = msg.responseText;
                    console.log(errorText.indexOf('您没有该项权限！'));
                    alert('您没有该项权限');
                    return;
                }
            })
        })
    </script>
@stop