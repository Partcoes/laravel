@extends('adminlte::page')
<base href="/storage/"></base>
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
    .null{
        color:#ccc;
    }
    .thumb{
        widows: 30px;
        height: 30px;
    }
</style>
@section('title', 'Dashboard')

@section('content_header')
    <h1>分类管理</h1>
    <hr/>
@stop

@section('content')
    <div id="parent" style="height:100%;osition: relative !important;">
        <p id="alone_head">
            @if($alones)
                @foreach($alones as $k => $alone)
                    <a href="/{{$alone -> button_url}}" class="btn {{$alone -> class}}">{{$alone -> button_name}}</a>
                @endforeach
            @endif
        </p>
        <table class="table table-responsive">
            <tr>
                <th>#</th>
                <th>类型名称</th>
                <th>类型服务</th>
                <th>缩略图</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            @foreach($types as $k => $type)
                <tr>
                    <th><input type="checkbox" value="{{$type['type_id']}}"></th>
                    <td>{{$type['type_name']}}</td>
                    <th>@if($type['type_status'] == 0)<span class="status_normal">宣传页</span>@elseif($type['type_status'] == 1)<span class="status_normal">商品列表</span>@endif</th>
                    <td>@if(!empty($type -> icon))<img class="thumb" src="{{$type -> icon}}" alt="">@else<span class="null">Null</span>@endif</td>
                    <th>@if($type['is_delete'] == 0)<span class="status_stop">停用</span>@elseif($type['is_delete'] == 1)<span class="status_normal">正常</span>@endif</th>
                    <th>
                        @if($buttons)
                            @foreach($buttons as $k => $button)
                                @if($button -> code == 'button')
                                <{{$button->code}} delete="delete"  status="{{$type -> is_delete}}" alerturl="{{url($button -> button_url)}}?rand={{$type -> type_id}}" class="btn {{$button -> class}}">{{$button -> button_name}}</{{$button -> code}}>
                                @else
                                <{{$button->code}} href="{{url($button -> button_url)}}?rand={{$type -> type_id}}"  status="{{$type -> is_delete}}" class="btn {{$button -> class}}">{{$button -> button_name}}</{{$button -> code}}>
                                @endif
                            @endforeach
                        @endif
                    </th>
                </tr>
            @endforeach
        </table>
        <div style="position: absolute !important;left:40% !important;bottom:20%;">{{ $types ->links() }}</div>
    </div>
@stop

@section('css')

@stop

@section('js')
    <script>
        $("button[delete='delete']").click(function(){
            var url = $(this).attr('alerturl');
            var obj = $(this);
            var status = obj.attr('status');
            if(status == 0){
                status = 1;
            }else{
                status =0;
            }
            $.ajax({
                url:url,
                type:'get',
                data:{status:status},
                success:function(msg){
                    if(msg == 1) {
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