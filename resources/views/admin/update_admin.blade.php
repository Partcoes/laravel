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
    <h1>修改管理员</h1>
    <hr/>
@stop

@section('content')
    <form action="{{ url('admin/update') }}" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}

        <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
            <input type="text" name="admin_name" class="form-control" value="{{$admin -> admin_name}}"
                   placeholder="请输入您的账户名">
            <input type="hidden" name="admin_id" value="{{$admin -> admin_id}}">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
            <input type="email" name="email" class="form-control" value="{{$admin -> email}}"
                   placeholder="请输入邮箱">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
            <input type="password" name="password" class="form-control"
                   placeholder="请输入密码">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
            <input type="tel" name="mobile" value="{{$admin -> mobile}}" class="form-control"
                   placeholder="请输入手机号">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
            @foreach($roles as $k => $role)
                <label class="checkbox-inline">
                    <input type="checkbox" name="role_id[]" @if(in_array($role -> role_id,$ship)) checked @endif value="{{$role -> role_id}}">{{$role -> role_name}}
                </label>
            @endforeach
        </div>
        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
            <label class="radio-inline">
                <input type="radio" name="admin_status" @if($admin -> admin_status ==  0)) checked @endif value="{{$admin -> admin_status}}">冻结
            </label>
            <label class="radio-inline">
                <input type="radio" name="admin_status" @if($admin -> admin_status ==  1)) checked @endif value="{{$admin -> admin_status}}">正常
            </label>
        </div>
        <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
            <b>管理员头像：</b>
            <p></p>
            <input type="file" name="admin_thumb" multiple>
        </div>
        <button type="submit"
                class="btn btn-primary btn-block btn-flat"
        >更新信息</button>
    </form>
    <!-- /.box-body -->

    {{--<div class="box-footer">--}}
    {{--<button type="submit" class="btn btn-primary">Submit</button>--}}
    {{--</div>--}}
    </form>
@stop

@section('css')

@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop