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
    <h1>添加类型</h1>
    <hr/>
@stop

@section('content')
    <form action="" method="post">
        {!! csrf_field() !!}

        <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
            <input type="text" name="typeof_name" class="form-control" value="{{ old('name') }}"
                   placeholder="类型名称">
        </div>
        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
            <input type="text" class="form-control" name="typeof_num">
        </div>
        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}"">
            <label>
                <input type="radio" name="typeof_status" value="1" class="minimal" checked>
            </label>
            <label>
                <input type="radio" class="minimal" disabled>正常
            </label>
            <label style="margin-left: 15px;">
                <input type="radio" name="typeof_status" class="minimal">
            </label>
            <label>
                <input type="radio" class="minimal" value="0" disabled>停用
            </label>
        </div>
        <button type="submit"
                class="btn btn-primary btn-block btn-flat"
        >添加类型</button>
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
    <script>
        $("input[name='typeof_num']").blur(function(){
            var typeof_num = $(this).val();
            if(isNaN(parseInt(typeof_num))){
                $(this).prop('value',0);
            }else{
                $(this).prop('value',parseInt(typeof_num));
            }
        })
    </script>
@stop