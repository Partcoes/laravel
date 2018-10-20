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
    <h1>添加角色</h1>
    <hr/>
@stop

@section('content')
    <form action="" method="post">
        {!! csrf_field() !!}

        <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
            <input type="text" name="role_name" class="form-control" value="{{ old('name') }}"
                   placeholder="角色名称">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
            <label class="radio-inline">
                <input type="radio" name="role_status" value="0">停用
            </label>
            <label class="radio-inline">
                <input type="radio" checked name="role_status" value="1">正常
            </label>
        </div>
        <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
            {{--@foreach($roles as $k => $role)--}}
                {{--<label class="checkbox-inline">--}}
                    {{--<input type="checkbox" name="role_id[]" value="{{$role -> role_id}}">{{$role -> role_name}}--}}
                {{--</label>--}}
            {{--@endforeach--}}
        </div>
        <button type="submit"
                class="btn btn-primary btn-block btn-flat"
        >添加角色</button>
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