{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')
@extends('layouts.javascript')

@section('title', 'Report')

@section('content_header')
    <h1>Generate Report</h1>
@stop

@section('content')
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
            <form method="post" action='{{ action ('ReportController@GenerateReport')}}'>
                <div class="box-header"></div>

                <div class="box-body">
                    <div class="row">
                <div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    
                        <div class="form-group" class="input">
                            <label  class="col-sm-2 control-label">
                                
                            
                          <input name="empId" type='hidden' class="form-control"/>
                          </label>
                        </div>
                         <div class="form-group">
                            <label  class="col-sm-2 control-label">
                                Start
                            </label>
                            <div class='input-group date' id='startDate'>

                            <input type='text' class="form-control"  id='startDateValue'  name='startDate' required/>
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                            </div>
                            
                         <div class="form-group">
                            <label  class="col-sm-2 control-label">
                                End
                            </label>
                            <div class='input-group date' id='endDate'>

                            <input type='text' class="form-control"  id='endDateValue'  name='endDate' required/>
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                            </div>
                        {{csrf_field()}}
                        <button type ="submit" class="btn btn-success"><span class="glyphicon glyphicon-list"></span></button>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                            <div class="form-group">
                            <label  class="col-sm-12 control-label">
                            Employees
                        <div class="form-group">
                        <div class ="checkbox">
                        <div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <table class="table table-bordered table-stripedss" id="dataTable" role="grid">
                        <thead>
                            <tr>
                                <th><label><input name="allEmp" id="all" type="checkbox" value="all"/></label></th>
                                <th>ID<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Name<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Phone<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Card Number<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Department<span class="glyphicon glyphicon-sort pull-right"></span></th>
                            </tr>
                        </thead>
                        <tbody>
                       @foreach($Employee as $emp)
                        <tr>
                            <td>
                            <label><input name="empIds[]" id="{{ $emp->id }}" type="checkbox" value="{{ $emp->id  }}"/></label>
                        </td>
                            <td>{{ $emp->id }}</td>
                            <td>{{ $emp->name }}</td>
                            <td>{{ $emp->phone }}</td>
                            <td>{{ $emp->card_number }}</td>
                            <td>{{ $emp->department->name }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
        </label>
            </div>
        </div></div>
                
                	
                
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <script src='{{asset("vendor/adminlte/plugins/datatables/dataTables.bootstrap.css") }}'></script>
    <link rel="stylesheet" href='{{asset("css/bootstrap-datetimepicker.min.css" )}}'/>
@stop

@section('js')
<script type="text/javascript">

$(document).ready(function() {

    $('#startDate').datetimepicker();
  $('#endDate').datetimepicker();
})
</script>

<script src='{{asset("js/moment.min.js")}}'></script>
<script src='{{asset("js/bootstrap-datetimepicker.min.js")}}'></script>
<!-- DataTables -->
<script type="text/javascript" src= '{{asset("vendor/adminlte/plugins/datatables/jquery.dataTables.min.js")}}'></script>
<script type="text/javascript" src= '{{asset("vendor/adminlte/plugins/fastclick/fastclick.min.js")}}'></script>
<script type="text/javascript" src= '{{asset("vendor/adminlte/plugins/datatables/dataTables.bootstrap.min.js")}}'></script>
<script>
$(function () {
$('#dataTable').DataTable();
});
</script>
@stop
