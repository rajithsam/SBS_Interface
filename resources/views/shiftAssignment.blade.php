{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')
@extends('layouts.javascript')

@section('title', 'Assign Shifts')

@section('content_header')
    <h1>{{$Employee[0]->name}} Shifts</h1>
@stop

@section('content')

    <div class="row">
      <div class="col-xs-12">
        <div class="box">
                <div class="box-header"></div>

                <div class="box-body">

                <div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                     <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#addShift" data-whatever="@mdo"><span class="glyphicon glyphicon-plus"></span></button>

                    <table class="table table-bordered table-stripedss" id="dataTable" role="grid">
                        <thead>
                            <tr>
                                <th>ID<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Name<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Start Date<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>End Date<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                       @for($i =0; $i < count($Employee[0]->shifts); $i++)
                        <tr>
                            <td>{{ $Employee[0]->shifts[$i]->id }}</td>
                            <td>{{ $Employee[0]->shifts[$i]->name }}</td>
                            <td>{{ $Employee[0]->shifts[$i]->startDate }}</td>
                            <td>{{ $Employee[0]->shifts[$i]->endDate }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addShift" data-id= {{ $i }} ><span class="glyphicon glyphicon-edit"></span></button>
                                <a class="btn btn-danger" href="/ShiftAssignment/delete/{{$Employee[0]->shifts[$i]->id}}" ><span class="glyphicon glyphicon-remove"></span></a>
                            </td>
                        </tr>
                        @endfor
                      </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="addShift" tabindex="-1" role="dialog" aria-labelledby="addShiftLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addShiftLabel">Assign Shift</h4>
      </div>
       <div class="modal-body">
      <form method="post" action='{{ action ('ShiftAssignmentController@update')}}'>

        <div class="form-group">
                        <div class="container">
                  <div class="row">
                  <div class='col-sm-6'>
            Shift 
          <select class="selectpicker" id="selectShift" name="selectShift" required>
            @foreach($Shifts as $Shift)
            <option value={{ $Shift->id }}>{{ $Shift->name }}</option>
            @endforeach
              </select>
            </div>
        </div></div>
    </div>

    <input type="hidden" id="empId" name="empId" value="{{$Employee[0]->id}}"/>
          <div class="form-group">
            <div class="container">
                  <div class="row">
                  <div class='col-sm-6'>
                    Start
                  <div class='input-group date' id='addSaturdayStartPicker'>
                    <input type='text' id="addStartSaturday" name="addStartSaturday" class="form-control" required/>
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                  </div>
                  </div>
                  </div>
          </div></div>

                    <div class="form-group">
            <div class="container">
                  <div class="row">
                  <div class='col-sm-6'>
                    End
                  <div class='input-group date' id='addSaturdayEndPicker'>
                    <input type='text' name="addEndSaturday" id="addEndSaturday" class="form-control" required/>
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                  </div>
                  </div>
                  </div>
          </div></div>
        
      <div class="modal-footer">
        <input type="hidden" id="ShiftId" name="ShiftId" value="">
        {{ csrf_field() }}
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
</div>
</div>
</div>
@stop

@section('css')
    <script src='{{asset("vendor/adminlte/plugins/datatables/dataTables.bootstrap.css") }}'></script>
    <link rel="stylesheet" href='{{asset("css/bootstrap-datetimepicker.min.css" )}}'/>
    <script src='{{asset("vendor/adminlte/plugins/datatables/dataTables.bootstrap.css") }}'></script>
@stop

@section('js')
<script type="text/javascript">
$(document).ready(function() {

    $('#addShift').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
    if(id == null)
    {
      $('#selectShift').val(-1)
      $('#addShiftName').val('')

      return
    }
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead. 
      var modal = $(this)
        
        $('#selectShift').val(window.Employee[0].shifts[id].shift_id)
        $('#addShiftName').val(window.Employee[0].shifts[id].name)
        $('#ShiftId').val(window.Employee[0].shifts[id].id)
      $('#addSaturdayStartPicker').data("DateTimePicker").date(window.Employee[0].shifts[id].startDate)
      $('#addSaturdayEndPicker').data("DateTimePicker").date(window.Employee[0].shifts[id].endDate)
      });

$('#addSaturdayStartPicker').datetimepicker({
     format: 'YYYY-MM-DD'
});

$('#addSaturdayEndPicker').datetimepicker({
    format: 'YYYY-MM-DD'
      });
});

</script>
<script src='{{asset("js/moment.min.js")}}'></script>
<script src='{{asset("js/bootstrap-datetimepicker.min.js")}}'></script
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
