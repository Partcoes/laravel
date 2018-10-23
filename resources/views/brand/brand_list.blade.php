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
    <h1>商品管理</h1>
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
                <th>品牌名称</th>
                <th>品牌官网</th>
                <th>品牌log</th>
                <th>品牌状态</th>
                <th>品牌简介</th>
                <th>操作</th>
            </tr>
            @foreach($brands as $k => $brand)
                <tr>
                    <th><input type="checkbox" value="{{$brand -> brand_id}}"></th>
                    <td>{{$brand -> brand_name}}</td>
                    <td>{{$brand -> brand_url}}</td>
                    <td>@if(!empty($brand -> brand_log)){{$brand -> brand_log}}@else<span class="null">Null</span>@endif</td>
                    <th>@if($brand -> brand_status == 0)<span class="status_stop">×</span>@elseif($brand -> brand_status == 1)<span class="status_normal">√</span>@endif</th>
                    <td>{{$brand -> brand_brief}}</td>
                    <th>
                        @if($buttons)
                            @foreach($buttons as $k => $button)
                                @if($button -> button_name == '删除')
                                    <button href="javascript:void(0)" alerturl="{{url($button -> button_url)}}?id={{$brand-> brand_id}}" class="btn {{$button -> class}}">{{$button -> button_name}}</button>
                                @else
                                    <a href="{{url($button -> button_url)}}?id={{$brand-> brand_id}}" alerturl="{{url($button -> button_url)}}?id={{$brand-> brand_id}}" class="btn {{$button -> class}}">{{$button -> button_name}}</a>
                                @endif
                            @endforeach
                        @endif
                    </th>
                </tr>
            @endforeach
        </table>
        <div style="position: absolute !important;left:40% !important;top:60%;">{{ $brands->links() }}</div>
    </div>
@stop

@section('css')

@stop

@section('js')
    <script>
        $("button[href='javascript:void(0)']").click(function(){
            var url = $(this).attr('alerturl');
            var obj = $(this);
            $.ajax({
                url:url,
                type:'get',
                success:function(msg){
                    if(msg == 1) {
                        obj.parents('tr').remove();
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