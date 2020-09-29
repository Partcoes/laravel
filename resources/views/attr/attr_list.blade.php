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
    .null{
        color:#ccc;
    }
</style>
@section('title', 'Dashboard')

@section('content_header')
    <h1>属性管理</h1>
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
                <th>属性名</th>
                <th>属性类型</th>
                <th>属性状态</th>
                <th>可选值</th>
                <th>操作</th>
            </tr>
            @foreach($attrs as $k => $attr)
                <tr>
                    <th><input type="checkbox" value="{{$attr -> attr_id}}"></th>
                    <td>{{$attr -> attr_name}}</td>
                    <th>@if($attr -> attr_type == 1)<span class="">属性</span>@elseif($attr -> attr_type == 2)<span class="">规格</span>@endif</th>
                    <th>@if($attr -> attr_status == 0)<span class="status_stop">停用</span>@elseif($attr -> attr_status == 1)<span class="status_normal">正常</span>@endif</th>
                    <td>{{$attr -> attr_value}}</td>
                    <th>
                        @if($buttons)
                            @foreach($buttons as $k => $button)
                                @if($button -> button_name == '删除'|| $button -> button_name == '停用/启用')
                                    <button delete="remove" status="{{$attr -> attr_status}}" href="javascript:void(0)" alerturl="{{url($button -> button_url)}}?attr_id={{$attr -> attr_id}}" class="btn {{$button -> class}}">{{$button -> button_name}}</button>
                                @else
                                    <a href="{{url($button -> button_url)}}?attr_id={{$attr-> attr_id}}" alerturl="{{url($button -> button_url)}}?id={{$attr -> attr_id}}" class="btn {{$button -> class}}">{{$button -> button_name}}</a>
                                @endif
                            @endforeach
                        @endif
                    </th>
                </tr>
            @endforeach
        </table>
        <div style="position: absolute !important;left:40% !important;top:60%;">{{ $attrs -> appends(['id'=>$id]) ->links() }}</div>
    </div>
@stop

@section('css')

@stop

@section('js')
    <script>
        $("button[delete='remove']").click(function(){
            var url = $(this).attr('alerturl');
            var obj = $(this);
            var status = obj.attr('status');
            $.ajax({
                url:url,
                type:'get',
                data:{attr_status:status},
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