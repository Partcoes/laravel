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
    select{width: 100%;font-size: 1em;color: @white;background-color: @darkBlue;background: url(../img/down.png) no-repeat center right;background-size: .8em; -moz-appearance: none;
        -webkit-appearance:none;appearance:none;
    option{background-color: @darkBlue;}
    }
</style>
@section('title', 'Dashboard')

@section('content_header')
    <h1>添加按钮</h1>
    <hr/>
@stop

@section('content')
    <form action="" method="post">
        {!! csrf_field() !!}

        <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
            <input type="text" name="button_name" class="form-control" value="{{ old('name') }}"
                   placeholder="按钮名称">
            <span style="position: absolute; right: 10px;bottom:10px;" class="fa fa-fw fa-navicon"></span>
        </div>
        <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
            <input type="text" name="button_url" class="form-control" value="{{ old('email') }}"
                   placeholder="按钮路由地址控制器/动作，例如：exmple/way">
            <span style="position: absolute; right: 10px;bottom:10px;" class="fa fa-fw fa-paper-plane-o"></span>
        </div>
        <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
            <label class="radio-inline">
                <input type="radio" name="button_group" value="0">顶部按钮
            </label>
            <label class="radio-inline">
                <input type="radio" checked name="button_group" value="1">行按钮
            </label>
        </div>
        <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
            <select name="class" id="select" class="form-control">
                <option value="">请选择图标</option>
                @foreach($icons as $k => $icon)
                    <option value="{{$icon}}">{{$icon}}</option>
                @endforeach
            </select>
            <span id="icon" style="position: absolute; right: 0px;bottom:1px;" class=""></span>
        </div>
        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
            <select name="menu_id" id="parent-menu" class="form-control">
                <option value="0">顶级菜单</option>
                @foreach($menus as $k => $menu)
                    <option icon="{{$menu -> icon}}" type="{{$menu -> icon_status}}" value="{{$menu -> menu_id}}">{{str_repeat('- ',substr_count($menu -> path,'-')+1).'>' . $menu -> menu_name}}</option>
                @endforeach
            </select>
            <span id='parent-icon' style="position: absolute; right: 10px;bottom:10px;" class="btn "></span>
        </div>
        <button type="submit"
                class="btn btn-primary btn-block btn-flat"
        >添加按钮</button>
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