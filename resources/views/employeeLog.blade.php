{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')
@extends('layouts.javascript')

@section('title', 'Logs')

@section('content_header')
    <h1>Employee Logs</h1>
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
                                <th>Name<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Phone<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Card Number<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Department<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                       @for($i =0; $i < count($Employee); $i++)
                        <tr>
                            <td>{{ $Employee[$i]->id }}</td>
                            <td>{{ $Employee[$i]->name }}</td>
                            <td>{{ $Employee[$i]->phone }}</td>
                            <td>{{ $Employee[$i]->card_number }}</td>
                            <td>{{ $Employee[$i]->department->name }}</td>
                            <td>
                                <a class="btn btn-primary" href="/AttendenceLog/events/{{$Employee[$i]->id}}" ><span class="glyphicon glyphicon-list"></span></a>
                            </td>
                        </tr>
                        @endfor
                    </table>
                </tbody>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
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