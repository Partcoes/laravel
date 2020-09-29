@extends('adminlte::page')
<link rel="stylesheet" href="http://adminlte.la998.com/plugins/iCheck/all.css">
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
    <h1>添加属性</h1>
    <hr/>
@stop

@section('content')
    <form action="" method="post">
        {!! csrf_field() !!}

        <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
            <input type="text" name="attr_name" class="form-control" value="{{ old('name') }}"
                   placeholder="属性名称">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
            <select name="typeof_id" id="" class="form-control">
                <option value="">请选择类型</option>
                @foreach($classes as $k => $class)
                    <option value="{{$class -> typeof_id}}">{{$class -> typeof_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}"">
            <label>
                <input type="radio" name="attr_status" value="1" class="minimal" checked>
            </label>
            <label>
                <input type="radio" class="minimal" disabled>正常
            </label>
            <label style="margin-left: 15px;">
                <input type="radio" name="attr_status" class="minimal">
            </label>
            <label>
                <input type="radio" class="minimal" value="0" disabled>停用
            </label>
        </div>
        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}"">
            <label>
                <input type="radio" name="attr_type" value="1" class="minimal" checked>
            </label>
            <label>
                <input type="radio" class="minimal" disabled>属性
            </label>
            <label style="margin-left: 15px;">
                <input type="radio" name="attr_type" value="2" class="minimal">
            </label>
            <label>
                <input type="radio" class="minimal" disabled>规格
            </label>
        </div>
        <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
            <textarea name="attr_value" id="" cols="10" rows="5" placeholder="属性可选值，多个请用逗号隔开" class="form-control"></textarea>
        </div>
        <button type="submit"
                class="btn btn-primary btn-block btn-flat"
        >添加属性</button>
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
    <script src="/vendor/Adminlte/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(function () {
            //初始化InputMask控件

            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            })
            //Red color scheme for iCheck
            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
                radioClass: 'iradio_minimal-red'
            })
            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            })
        });

    </script>
    <script> console.log('Hi!'); </script>
@stop