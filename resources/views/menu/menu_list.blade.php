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
    .name-left{
        text-align: left !important;
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
    <h1>菜单管理</h1>
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
                <th class="name-left">菜单名称</th>
                <th>菜单路由</th>
                <th>icon名称</th>
                <th>菜单图标</th>
                <th>操作</th>
            </tr>
            @foreach($menus as $k => $menu)
                <tr>
                    <th>{{$menu -> menu_id}}</th>
                    <td class="name-left">{!!str_repeat("<span class='fa fa-fw  fa-forward'></span>",substr_count($menu -> path,'-')+1) . $menu -> menu_name!!}</td>
                    <td>{{$menu -> menu_url}}</td>
                    <th>{{$menu -> icon}}</th>
                    {{--<th>@if($menu -> menu_status == 0)<span class="status_stop">冻结</span>@elseif($menu -> menu_status == 1)<span class="status_normal">正常</span>@endif</th>--}}
                    <td>@if($menu -> icon_status == 1)<span class="fa fa-fw fa-circle-o text-{{$menu -> icon}}"></span>@else<span class="fa fa-fw fa-{{$menu -> icon}}"></span>@endif</td>
                    <th>
                        @if($buttons)
                            @foreach($buttons as $k => $button)
                                @if($button -> button_name == '删除')
                                    <button delete="delete" alerturl="{{url($button -> button_url)}}?id={{$menu -> menu_id}}" class="btn {{$button -> class}}">{{$button -> button_name}}</button>
                                @else
                                    <a href="{{url($button -> button_url)}}?id={{$menu-> menu_id}}" alerturl="{{url($button -> button_url)}}?id={{$menu -> menu_id}}" class="btn {{$button -> class}}">{{$button -> button_name}}</a>
                                @endif
                            @endforeach
                        @endif
                    </th>
                </tr>
            @endforeach
        </table>
        <div style="position: absolute !important;left:40% !important;top:65%;">{{$menus -> links()}}</div>
    </div>
@stop

@section('css')

@stop

@section('js')
    <script>
        $("button[delete='delete']").click(function(){
            var url = $(this).attr('alerturl');
            var obj = $(this);
            $.ajax({
                url:url,
                type:'get',
                success:function(msg){
                    if(msg == 1) {
                        obj.parents('tr').remove();
                    }else{
                        alert('删除失败！');
                    }
                },
                error:function(msg){
                    var errorText = msg.responseText;
                    errorText.indexOf('您没有该项权限！');
                    alert('您没有该项权限');
                    return;
                }
            })
        })
    </script>
@stop