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
    <h1>角色管理</h1>
    <hr/>
@stop

@section('content')
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
            <th>角色</th>
            <th>状态</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
        @foreach($roles as $k => $role)
            <tr>
                <th><input type="checkbox" value="{{$role -> role_id}}"></th>
                <td>{{$role -> role_name}}</td>
                <th>@if($role -> role_status == 0)<span class="status_stop">停用</span>@elseif($role -> role_status == 1)<span class="status_normal">正常</span>@endif</th>
                <td>{{date('Y-m-d H:i:s',$role -> create_time)}}</td>
                <td>{{date('Y-m-d H:i:s',$role ->  update_time)}}</td>
                <th>
                    @if($buttons)
                        @foreach($buttons as $k => $button)
                            @if($button -> button_name == '删除')
                                <button href="javascript:void(0)" alerturl="{{url($button -> button_url)}}?id={{$role -> role_id}}" class="btn {{$button -> class}}">{{$button -> button_name}}</button>
                            @else
                                <a href="{{url($button -> button_url)}}?id={{$role-> role_id}}" alerturl="{{url($button -> button_url)}}?id={{$role -> role_id}}" class="btn {{$button -> class}}">{{$button -> button_name}}</a>
                            @endif
                        @endforeach
                    @endif
                </th>
            </tr>
        @endforeach
    </table>
@stop

@section('css')

@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop