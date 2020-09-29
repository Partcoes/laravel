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
    <h1>按钮管理</h1>
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
                <th>按钮名称</th>
                <th>页面</th>
                <th>class</th>
                <th>按钮图标</th>
                <th>操作</th>
            </tr>
            @foreach($buttons as $k => $button)
                <tr>
                    <th><input type="checkbox" value="{{$button -> button_id}}"></th>
                    <td>{{$button['button_name']}}</td>
                    <td>{{$button['menu_name']}}</td>
                    <td>{{$button['class']}}</td>
                    <td style="text-align: left !important;"><button class="btn @if(!empty($button['class'])) {{$button['class']}} @else btn-default @endif">{{$button['button_name']}}</button></td>
                    <th>
                        @if($groups)
                            @foreach($groups as $k => $group)
                                @if($group -> button_name == '删除')
                                    <button delete="delete" alerturl="/{{$group -> button_url}}?id={{$button['button_id']}}"  class="btn {{$group -> class}}">{{$group -> button_name}}</button>
                                @else
                                    <a href="/{{$group -> button_url}}?rand={{$button['button_id']}}" class="btn {{$group -> class}}">{{$group -> button_name}}</a>
                                @endif
                            @endforeach
                        @endif
                    </th>
                </tr>
            @endforeach
        </table>
        <div style="position: absolute !important;left:40% !important;top:60%;">{{ $buttons->links() }}</div>
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