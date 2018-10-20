@extends('adminlte::page')
<style>
    table{
        width: 30% !important;
    }
    th{
        border-right: 1px solid #8c8c8c !important;
        border-bottom: 1px solid #8c8c8c !important;
    }
    td{
        border-bottom: 1px solid #8c8c8c !important;
        /*width: 80% !important;*/
    }
    .detail{
        background: white;
    }
    img{
        width: 70px;
        height: 50px;
    }
</style>
@section('title', 'Dashboard')

@section('content_header')
    <table class="table table-striped table-hover">
        <tr class="detail">
            <th>头像：</th>
            <td><img src="{{$detail -> admin_thumb}}" alt=""></td>
        </tr>
        <tr class="detail">
            <th>管理员名称：</th>
            <td>{{$detail -> admin_name}}</td>
        </tr>
        <tr  class="detail">
            <th>邮箱：</th>
            <td>{{$detail -> admin_name}}</td>
        </tr>
        <tr  class="detail">
            <th>手机号：</th>
            <td>{{$detail -> mobile}}</td>
        </tr>
        <tr  class="detail">
            <th>是否超级管理：</th>
            <td>@if($detail -> admin_type == 1)是@else 否 @endif</td>
        </tr>
        <tr  class="detail">
            <th>状态：</th>
            <td>@if($detail -> admin_status == 1)正常@else 冻结 @endif</td>
        </tr>
        <tr  class="detail">
            <th>创建者：</th>
            <td>{{$detail -> operator}}</td>
        </tr>
        <tr  class="detail">
            <th>创建时间：</th>
            <td>{{date('Y-m-d H:i:s',$detail -> create_time)}}</td>
        </tr>
        <tr  class="detail">
            <th>修改时间：</th>
            <td>{{date('Y-m-d H:i:s',$detail -> update_time)}}</td>
        </tr>
    </table>
@stop

@section('content')

@stop

@section('css')

@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop