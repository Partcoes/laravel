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
                <th>商品名</th>
                <th>商品货号</th>
                <th>商品价格</th>
                <th>上架</th>
                <th>商品库存</th>
                <th>操作</th>
            </tr>
            @foreach($goods as $k => $good)
                <tr>
                    <th><input type="checkbox" value="{{$good -> goods_id}}"></th>
                    <td>{{$good -> goods_name}}</td>
                    <td>{{$good -> goods_sn}}</td>
                    <td>@if(!empty($good -> shop_price)){{$good -> shop_price}}@else<span class="null">Null</span>@endif</td>
                    <th>@if($good -> is_up == 0)<span class="status_stop">×</span>@elseif($good -> is_up == 1)<span class="status_normal">√</span>@endif</th>
                    <td>{{$good -> goods_number}}</td>
                    <th>
                        @if($buttons)
                            @foreach($buttons as $k => $button)
                                @if($button -> button_name == '删除')
                                    <button href="javascript:void(0)" alerturl="{{url($button -> button_url)}}?id={{$good -> goods_id}}" class="btn {{$button -> class}}">{{$button -> button_name}}</button>
                                @else
                                    <a href="{{url($button -> button_url)}}?id={{$good-> goods_id}}" alerturl="{{url($button -> button_url)}}?id={{$good -> goods_id}}" class="btn {{$button -> class}}">{{$button -> button_name}}</a>
                                @endif
                            @endforeach
                        @endif
                    </th>
                </tr>
            @endforeach
        </table>
        <div style="position: absolute !important;left:40% !important;top:60%;">{{ $goods->links() }}</div>
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