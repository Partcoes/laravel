@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div style="width:50% !important;height:300px !important;margin:0 auto !important;text-align: center;">
        <h3>欢迎 <span style="color:blue">{{session('admin_login')['admin_name']}}</span> 登陆！</h3>
    </div>
@stop

@section('content')

@stop

@section('css')

@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop