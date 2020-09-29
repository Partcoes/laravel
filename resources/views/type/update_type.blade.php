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
    <h1>修改分类</h1>
    <hr/>
@stop

@section('content')
    <form action="" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}

        <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}" style="position: relative !important;">
            <input type="text" name="type_name" class="form-control" value="{{$typed -> type_name}}"
                   placeholder="分类名称">
            <input type="hidden" name="type_id" value="{{$rand}}">
            <span style="position: absolute!important;right:0.5% !important;top: 35%!important;" class="fa fa-fw fa-sitemap"></span>
        </div>
        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
            <label class="radio-inline">
                <input type="radio"@if($typed -> type_status == 0) checked @endif name="type_status" value="0">宣传页
            </label>
            <label class="radio-inline">
                <input type="radio"@if($typed -> type_status == 1) checked @endif name="type_status" value="1">列表
            </label>
        </div>
        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
            <div class="form-group">
                <select name="parent_id" id="" class="form-control">
                    <option value="0">顶级分类</option>
                    @foreach($types as $k => $type)
                        <option value="{{$type -> type_id}}" @if($type -> type_id == $typed -> parent_id) selected @endif >{{str_repeat('--',$type -> level) .$type -> type_name}}</option>
                        @if(!empty($type -> son))
                            @foreach($type['son'] as $k => $tyson)
                            <option value="{{$tyson -> type_id}}" @if($tyson -> type_id == $typed -> parent_id) selected @endif>{{str_repeat('--',$tyson -> level) .$tyson -> type_name}}</option>
                            @endforeach
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
            <input type="file" style="outline: 0px white !important;" name="icon">
            {{--@foreach($roles as $k => $role)--}}
                {{--<label class="checkbox-inline">--}}
                    {{--<input type="checkbox" name="role_id[]" value="{{$role -> role_id}}">{{$role -> role_name}}--}}
                {{--</label>--}}
            {{--@endforeach--}}
        </div>
        <button type="submit"
                class="btn btn-primary btn-block btn-flat"
        >添加分类</button>
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