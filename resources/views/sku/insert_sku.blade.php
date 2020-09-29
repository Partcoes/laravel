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
    <h1>添加sku</h1>
    <hr/>
@stop

@section('content')
    <table width="100%" cellpadding="3" cellspacing="1" id="table_list"  class="table">
        <tbody><tr>
            <th colspan="20" scope="col">商品名称：{$data.goods_name} plus&nbsp;&nbsp;&nbsp;&nbsp;货号：{$data.goods_sn}</th>
        </tr>
        <tr>
            <!-- start for specifications -->
            {if condition="$new_arr['name']"}
            {foreach $new_arr['name'] as $key=>$val}
            <td scope="col" style="background-color: rgb(255, 255, 255);"><div align="center"><strong>{$val}</strong></div></td>
            {/foreach}
            {/if}
            <!-- end for specifications -->
            <td class="label_2" style="background-color: rgb(255, 255, 255);">货号</td>
            <td class="label_2" style="background-color: rgb(255, 255, 255);">库存</td>
            <td class="label_2" style="background-color: rgb(255, 255, 255);">&nbsp;</td>
        </tr>


        <tr id="attr_row">
            <!-- start for specifications_value -->
            {if condition="$new_arr['vals']"}
            {foreach $new_arr['vals'] as $key=>$val}
            <td align="center" style="background-color: rgb(255, 255, 255);">
                <select name="attr[{$key}][]">
                    <option value="" selected="">请选择...</option>
                    {if condition="$val"}
                    {foreach $val as $k=>$v}
                    <option value="{$k}">{$v}</option>
                    {/foreach}
                    {/if}
                </select>
            </td>
            {/foreach}
            {/if}
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

@stop