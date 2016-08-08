{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')
@extends('layouts.javascript')

@section('title', 'Report')

@section('content_header')
    <h1>Report</h1>
@stop

@section('content')
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
                <div class="box-header"></div>

                <div class="box-body">

                <div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                    
               
                <div class="panel-body">
                    <form  method="post" action='{{ action ('ReportController@DownloadSummary')}}'>
                        <input type="hidden" name="startDate" value={{$StartDate}}>
                        <input  type="hidden" name="endDate" value={{$EndDate}}>
                        <input  type="hidden" name="empId" value={{$EmpIds}}>
                        {{csrf_field()}}
                        <button type ="submit" class="btn btn-success pull-right"><span class="glyphicon glyphicon-save-file"></span></button>
                    </form>

                    <table class="table table-bordered table-stripedss" id="dataTable" role="grid">
                        <thead>
                            <tr>
                                <th>ID<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Name<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Attendece Number<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Abscense Number<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Overtime Number<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Late Arrivals<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Early Departurre<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Start Date<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>End Date<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                       @for($i =0; $i < count($Record); $i++)
                        <tr>
                            <td>{{ $Record[$i]->empId }}</td>
                            <td>{{ $Record[$i]->empName }}</td>
                            <td>{{ $Record[$i]->attendenceNumber }}</td>
                            <td>{{ $Record[$i]->abscenseNumber }}</td>
                            <td>{{ $Record[$i]->overtimeNumber }}</td>
                            <td>{{ $Record[$i]->lateArrivals }}</td>
                            <td>{{ $Record[$i]->earlyDeparture }}</td>
                            <td>{{ $Record[$i]->startDate }}</td>
                            <td>{{ $Record[$i]->endDate }}</td>
                            <td>
                                <form  method="post" action='{{ action ('ReportController@GenerateDetailedReport')}}'>
                                    <input type="hidden" name="startDate" value={{$Record[$i]->startDate}}>
                                    <input  type="hidden" name="endDate" value={{$Record[$i]->endDate}}>
                                    <input  type="hidden" name="empId" value={{$Record[$i]->empId}}>
                                    {{csrf_field()}}
                                    <button type ="submit" class="btn btn-primary"><span class="glyphicon glyphicon-indent-left"></span></button>
                                </form>
                            </td>
                        </tr>
                        @endfor
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection

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