{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')
@extends('layouts.javascript')

@section('title', 'Logs')

@section('content_header')
    <h1>System Logs</h1>
@stop

@section('content')
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
                <div class="box-header"></div>

                <div class="box-body">

                <div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <table class="table table-bordered table-stripedss" id="dataTable" role="grid">
                        <thead>
                            <tr>
                                <th>ID<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>User<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Operation<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Old Value<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>New Value<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>IP<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Date<span class="glyphicon glyphicon-sort pull-right"></span></th>
                            </tr>
                        </thead>
                        <tbody>
                       @for($i =0; $i < count($Log); $i++)
                        <tr>
                            <td>{{ $Log[$i]->id }}</td>
                            <td>{{ $Log[$i]->user->name }}</td>
                            <td>{{ $Log[$i]->operation }}</td>
                            <td><a href="#" data-toggle="tooltip" title="{{ $Log[$i]->old_value }}">Old Values</a></td>
                            <td><a href="#" data-toggle="tooltip" title="{{ $Log[$i]->new_value }}">New Values</a></td>
                            <td>{{ $Log[$i]->ip }}</td>
                            <td>{{ $Log[$i]->created_at }}</td>
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
$('[data-toggle="tooltip"]').tooltip();   
});
</script>
@stop