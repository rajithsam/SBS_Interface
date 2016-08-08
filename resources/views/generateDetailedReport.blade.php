{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')
@extends('layouts.javascript')

@section('title', 'Report')

@section('content_header')
    <h1>{{$Employee->name}} Detailed Report</h1>
@stop

@section('content')
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
                <div class="box-header"></div>

                <div class="box-body">

                <div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                <div class="panel-body">
                    <form  method="post" action='{{ action ('ReportController@DownloadDetailed')}}'>
                        <input type="hidden" name="startDate" value={{$StartDate}}>
                        <input  type="hidden" name="endDate" value={{$EndDate}}>
                        <input  type="hidden" name="empId" value={{$EmpIds}}>
                        {{csrf_field()}}
                        <button type ="submit" class="btn btn-success pull-right"><span class="glyphicon glyphicon-save-file"></span></button>
                    </form>

                    <table class="table table-bordered table-stripedss" id="dataTable" role="grid">
                        <thead>
                            <tr>
                                <th>Date<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>First Check In<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Last Check Out<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Late Arrival<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Early Departure<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Type<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Approved<span class="glyphicon glyphicon-sort pull-right"></span></th>
                            </tr>
                        </thead>

                       @for($i =0; $i < count($Record); $i++)
                        <tr>
                            <td>{{ $Record[$i]->date }}</td>
                            <td>{{ $Record[$i]->firsIn }}</td>
                            <td>{{ $Record[$i]->lastOut }}</td>
                            <td>{{ $Record[$i]->lateArrival }}</td>
                            <td>{{ $Record[$i]->earlyDeparture }}</td>
                            <td>{{ $Record[$i]->type }}</td>
                            <td>{{ $Record[$i]->approved }}</td>
                        </tr>
                        @endfor
                    </table>

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