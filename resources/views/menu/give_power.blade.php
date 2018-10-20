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
    select{
        //代表不同的浏览器都去除三角
        -moz-appearance: none;
        -webkit-appearance:none;
        appearance:none ;
    }
    .indent{
        text-indent: 2em !important;
    }
    .menu-list{
        list-style: none !important;

    }
    .menu-ul{
        /*float: left !important;*/
        color:red;
    }

</style>
@section('title', 'Dashboard')

@section('content_header')
    <h1>角色赋权</h1>
    <hr/>
@stop

@section('content')
    <form action="" method="post">
        {!! csrf_field() !!}

        <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
            <select name="role_id" id="role-list" class="form-control">
                <option value="">请选择角色</option>
                @foreach($roles as $k => $role)
                    <option type="{{$role -> role_name}}" value="{{$role -> role_id}}">{{$role -> role_name}}</option>
                @endforeach
            </select>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div style="margin-bottom: 20px;"><span class="btn btn-facebook">全选</span></div>
        <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}" style="color:red">
            {{--<ul class="menu-ul">--}}
                @foreach($menus as $k => $menu)
                    {{--<li class="menu-list">--}}
                        <label class="checkbox-inline">
                            <input parent="0" type="checkbox" name="resource_id[]" value="{{$menu['menu_id']}}">{{$menu['text']}}
                        </label>
                    {{--</li>--}}
                <br>
                    @if(isset($menu['submenu']))
                        {{--<ul class="menu-ul">--}}
                            @foreach($menu['submenu'] as $subk => $submenus)
                                {{--<li class="menu-list">--}}
                                    <label class="checkbox-inline">
                                        <span style="margin-right: 25px !important;">|---</span><input child="{{$menu['menu_id']}}" type="checkbox" name="resource_id[]" value="{{$submenus['menu_id']}}">{{$submenus['text']}}
                                    </label>
                                {{--</li>--}}
                        <br>
                                @if(isset($submenus['submenu']))
                                    <ul class="menu-ul">
                                        @foreach($submenus['submenu'] as $subsk => $submenu)
                                            <li class="menu-list">
                                                <label class="checkbox-inline">
                                                    <span style="margin-right: 25px !important;">|------</span><input nextchild="{{$submenus['menu_id']}}" type="checkbox" name="resource_id[]" value="{{$submenu['menu_id']}}">{{$submenu['text']}}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                        {{--</ul>--}}
                    @endif
                @endforeach
            {{--</ul>--}}
        </div>
        <button type="submit"
                class="btn btn-primary btn-block btn-flat"
        >赋权</button>
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
        $('#role-list').change(function(){
            var roleid = $(this).val();
            var token = "{{@csrf_token()}}";
            // console.log(token);return;
            if(roleid == '') {
                cancelCehcked();
                return;
            }
            var role_type = $('option:selected').attr('type');
            if(role_type == "超级管理员"){
                allChecked();return;
            }
            $.ajax({
                type: "POST",
                url: "{{url('role/give')}}",
                data: "role_id="+roleid+'&_token='+ token,
                success: function(msg){
                    var check = $("input[type='checkbox']");
                    var menuid = JSON.parse(msg);
                    var menuids = [];
                    for(var i =0 ;i < menuid.length;i++){
                        menuids[i] = menuid[i];
                    }
                    check.each(function(){
                        if(jQuery.inArray(parseInt($(this).val()),menuids) != -1) {
                            $(this).prop('checked', true);
                        }else{
                            $(this).prop('checked',false);
                        }
                    })
                },
                error:function(errors){
                    var errorText = errors.responseText;
                    console.log(errorText.indexOf('您没有该项权限！'));return;
                }
            });

        })
        $("span[class='btn btn-facebook']").click(function(){
            allChecked();
            return;
        })
        function allChecked(){
            var checkbox = $("input[type='checkbox']");
            checkbox.each(function(){
                $(this).prop('checked',true);
            })
            return;
        }

        function cancelCehcked(){
            var checkbox = $("input[type='checkbox']");
            checkbox.each(function(){
                $(this).prop('checked',false);
            })
            return;
        }
    </script>
@stop