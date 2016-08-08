{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')
@extends('layouts.javascript')

@section('title', 'Connected Devices')

@section('content_header')
    <h1>Connected Devices</h1>
@stop

@section('content')
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
                <div class="box-header"></div>

                <div class="box-body">
                <form files='true' class="pull-right" enctype="multipart/form-data" method='post' action='{{ action ('HomeController@uploadImage')}}'>
                    <div class="form-group">
                    <input type="file" class="btn btn-default" name="file" accept="image/*" />
                </div>
                <div class="form-group">
                     <button type="submit" class="btn btn-success" data-whatever="@mdo"><span class="glyphicon glyphicon-open-file"></span></button>
                 </div>
                     {{ csrf_field() }}

               </form>
                <div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <table class="table table-bordered table-stripedss" id="dataTable" role="grid">
                        <thead>
                            <tr>
                                <th>ID<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>IP<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Actions<span class="glyphicon glyphicon-sort pull-right"></span></th>
                            </tr>
                        </thead>
                        <tbody>
                       @for($i =0; $i < count($Devices); $i++)
                        <tr>
                            <td>{{ $Devices[$i][1]}}</td>
                            <td>{{ $Devices[$i][0]}}</td>
                            <td>
                                <a class="btn btn-warning" href="/SyncDevice/{{$Devices[$i][0]}}" ><span class="glyphicon glyphicon-refresh"></span></a>
                            </td>
                        </tr>
                        @endfor
                    </tbod>
                    </table>

                </div>
            </div>
        </div>
    </div>
@stop
@section('css')
<script type="text/css">
div.tooltip-inner {
        max-width: 500px;
    }
    </script>
    <script src='{{asset("vendor/adminlte/plugins/datatables/dataTables.bootstrap.css") }}'></script>
@stop

@section('js')
<!-- DataTables -->
<script type="text/javascript" src= '{{asset("vendor/adminlte/plugins/datatables/jquery.dataTables.min.js")}}'></script>
<script type="text/javascript" src= '{{asset("vendor/adminlte/plugins/fastclick/fastclick.min.js")}}'></script>
<script type="text/javascript" src= '{{asset("vendor/adminlte/plugins/datatables/dataTables.bootstrap.min.js")}}'></script>
<script type="text/javascript">
$(function () {
$('#dataTable').DataTable(); 
});
</script>
@stop