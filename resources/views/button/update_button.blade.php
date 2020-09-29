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
    select{width: 100%;font-size: 1em;color: @white;background-color: @darkBlue;background: url(../img/down.png) no-repeat center right;background-size: .8em; -moz-appearance: none;
        -webkit-appearance:none;appearance:none;
    option{background-color: @darkBlue;}
    }
</style>
@section('title', 'Dashboard')

@section('content_header')
    <h1>修改按钮</h1>
    <hr/>
@stop

@section('content')
    <form action="" method="post">
        {!! csrf_field() !!}
        <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
            <input type="text" name="button_name" class="form-control" value="{{$button -> button_name}}"
                   placeholder="按钮名称">
            <input type="hidden" name="button_id" value="{{$button -> button_id}}">
            <span style="position: absolute; right: 10px;bottom:10px;" class="fa fa-fw fa-navicon"></span>
        </div>
        <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
            <input type="text" name="button_url" class="form-control" value="{{$button -> button_url}}"
                   placeholder="按钮路由地址控制器/动作，例如：exmple/way">
            <span style="position: absolute; right: 10px;bottom:10px;" class="fa fa-fw fa-paper-plane-o"></span>
        </div>
        <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
            <select name="class" id="select" class="form-control">
                <option value="">请选择图标</option>
                @foreach($icons as $k => $icon)
                    <option @if($button -> class == $icon) selected @endif value="{{$icon}}">{{$icon}}</option>
                @endforeach
            </select>
            <span id="icon" style="position: absolute; right: 0px;bottom:1px;" class=""></span>
        </div>
        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
            <select name="menu_id" id="parent-menu" class="form-control">
                @foreach($menus as $k => $menu)
                    <option icon="{{$menu -> icon}}" @if($button -> menu_id == $menu -> menu_id) selected @endif type="{{$menu -> icon_status}}" value="{{$menu -> menu_id}}">{{str_repeat('- ',substr_count($menu -> path,'-')+1).'>' . $menu -> menu_name}}</option>
                @endforeach
            </select>
            <span id='parent-icon' style="position: absolute; right: 10px;bottom:10px;" class="btn "></span>
        </div>
        <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
            <label>
                <input type="radio" @if($button -> button_group == 0) checked @endif name="button_group" value="0" class="minimal">
            </label>
            <label>
                <input type="radio" class="minimal" disabled>顶部按钮
            </label>
            <label style="margin-left: 15px;">
                <input type="radio" name="button_group" @if($button -> button_group == 1) checked @endif value="1" class="minimal">
            </label>
            <label>
                <input type="radio" class="minimal" value="0" disabled>行按钮
            </label>
        </div>
        <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
            <label>
                <input type="radio" name="code" @if($button -> code == 'button') checked @endif  value="button" class="minimal" checked>
            </label>
            <label>
                <input type="radio" class="minimal" disabled>ajax按钮
            </label>
            <label style="margin-left: 15px;">
                <input type="radio" @if($button -> code == 'a') checked @endif  value="a" name="code" class="minimal">
            </label>
            <label>
                <input type="radio" name="code" class="minimal" value="a" disabled>a链接
            </label>
        </div>
        <button type="submit"
                class="btn btn-primary btn-block btn-flat"
        >更新按钮</button>
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
        $('#select').change(function(){
            var val = $(this).val();
            var str = 'btn ';
            var button_name = $("input[name='button_name']").val();
            if(button_name == ''){
                button_name = "按钮";
            }
            $('#icon').prop('class',str + val);
            $('#icon').text(button_name);
            return;
        })
        $('#parent-menu').change(function(){
            var val = $(this).val();
            var str = 'btn ';
            $('#parent-icon').prop('class',str + val);
            return;

        });
    </script>
@stop