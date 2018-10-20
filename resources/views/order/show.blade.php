@extends('adminlte::page')
<style>
    table,tr,td{
        border: 1px solid #ccc !important;
        text-align: center;
    }
</style>
@section('title', 'Dashboard')

@section('content_header')
    <h1>订单列表</h1>
@stop

@section('content')
    {{--<iframe frameborder="0" name="menuFrame" style="overflow:visible;min-height: 450px;width: 100%;" src=""></iframe>--}}
    <table class="table table-active">
        <tr>
            <td>订单id</td>
            <td>订单名称</td>
            <td>订单详情</td>
            <td>订单用户</td>
            <td>操作</td>
        </tr>
        <tr>
            <td colspan="6">fasdfdfa</td>
        </tr>
    </table>
@stop

@section('css')

@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop