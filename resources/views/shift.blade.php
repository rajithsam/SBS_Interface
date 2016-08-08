{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')
@extends('layouts.javascript')

@section('title', 'Shifts')

@section('content_header')
    <h1>Edit Shifts</h1>
@stop

@section('content')
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
                <div class="box-header"></div>

                <div class="box-body">

                <div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    
                     <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#addShift"><span class="glyphicon glyphicon-plus"></span></button>
                    <table class="table table-bordered table-stripedss" id="dataTable" role="grid">
                        <thead>
                            <tr>
                                <th>ID<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Name<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                       @for($i =0; $i < count($Shift); $i++)
                        <tr>
                            <td>{{ $Shift[$i]->id }}</td>
                            <td>{{ $Shift[$i]->name }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addShift" data-id= {{ $i }} ><span class="glyphicon glyphicon-edit"></span></button>
                                <a class="btn btn-danger" href="delete/{{$Shift[$i]->id}}" ><span class="glyphicon glyphicon-remove"></span></a>
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
        <h4 class="modal-title" id="addShiftLabel">Add Shift</h4>
      </div>
       <div class="modal-body">
      <form method="post" action='{{ action ('ShiftController@update')}}'>

             <input id="addShiftName" name="addShiftName" value="" class="form-control" placeholder="Shift Name" required>
                  <div class="form-group">
            <div class="checkbox">
             <label><input name="addsaturdayCheck" id="addsaturdayCheck" type="checkbox" value=true checked>Sunday</label>
                    <br>
                </div>
              </div>

          <div class="form-group">
            <div class="container">
                  <div class="row">
                  <div class='col-sm-6'>
                    Start
                  <div class='input-group date' id='addSaturdayStartPicker'>
                    <input type='text' id="addStartSaturday" name="addStartSaturday" class="form-control" />
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-time"></span>
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
                    <input type='text' name="addEndSaturday" id="addEndSaturday" class="form-control" />
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-time"></span>
                  </div>
                  </div>
                  </div>
          </div></div>

          <div class="form-group">
            <div class="checkbox">
             <label><input name="addSundayCheck" id="addSundayCheck" type="checkbox" value=true checked>Sunday</label>
                    <br>
                </div>
              </div>

          <div class="form-group">
            <div class="container">
                  <div class="row">
                  <div class='col-sm-6'>
                    Start
                  <div class='input-group date' id='addSundayStartPicker'>
                    <input type='text' id="addStartSunday" name="addStartSunday" class="form-control" />
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-time"></span>
                  </div>
                  </div>
                  </div>
          </div></div>

                    <div class="form-group">
            <div class="container">
                  <div class="row">
                  <div class='col-sm-6'>
                    End
                  <div class='input-group date' id='addSundayEndPicker'>
                    <input type='text' name="addEndSunday" id="addEndSunday" class="form-control" />
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-time"></span>
                  </div>
                  </div>
                  </div>
          </div></div>

                    <div class="form-group">
            <div class="checkbox">
             <label><input name="addMondayCheck" id="addMondayCheck" type="checkbox" value=true checked>Monday</label>
                    <br>
                </div>
              </div>

          <div class="form-group">
            <div class="container">
                  <div class="row">
                  <div class='col-sm-6'>
                    Start
                  <div class='input-group date' id='addMondayStartPicker'>
                    <input type='text' id="addStartMonday" name="addStartMonday" class="form-control" />
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-time"></span>
                  </div>
                  </div>
                  </div>
          </div></div>

                    <div class="form-group">
            <div class="container">
                  <div class="row">
                  <div class='col-sm-6'>
                    End
                  <div class='input-group date' id='addMondayEndPicker'>
                    <input type='text' name="addEndMonday" id="addEndMonday" class="form-control" />
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-time"></span>
                  </div>
                  </div>
                  </div>
          </div></div>

                    <div class="form-group">
            <div class="checkbox">
             <label><input name="addTusedayCheck" id="addTusedayCheck" type="checkbox" value=true checked>Tuseday</label>
                    <br>
                </div>
              </div>

          <div class="form-group">
            <div class="container">
                  <div class="row">
                  <div class='col-sm-6'>
                    Start
                  <div class='input-group date' id='addTusedayStartPicker'>
                    <input type='text' id="addStartTuseday" name="addStartTuseday" class="form-control" />
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-time"></span>
                  </div>
                  </div>
                  </div>
          </div></div>

                    <div class="form-group">
            <div class="container">
                  <div class="row">
                  <div class='col-sm-6'>
                    End
                  <div class='input-group date' id='addTusedayEndPicker'>
                    <input type='text' name="addEndTuseday" id="addEndTuseday" class="form-control" />
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-time"></span>
                  </div>
                  </div>
                  </div>
          </div></div>


                  <div class="form-group">
            <div class="checkbox">
             <label><input name="addWednesdayCheck" id="addWednesdayCheck" type="checkbox" value=true checked>Wednesday</label>
                    <br>
                </div>
              </div>

          <div class="form-group">
            <div class="container">
                  <div class="row">
                  <div class='col-sm-6'>
                    Start
                  <div class='input-group date' id='addWednesdayStartPicker'>
                    <input type='text' id="addStartWednesday" name="addStartWednesday" class="form-control" />
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-time"></span>
                  </div>
                  </div>
                  </div>
          </div></div>

                    <div class="form-group">
            <div class="container">
                  <div class="row">
                  <div class='col-sm-6'>
                    End
                  <div class='input-group date' id='addWednesdayEndPicker'>
                    <input type='text' name="addEndWednesday" id="addEndWednesday" class="form-control" />
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-time"></span>
                  </div>
                  </div>
                  </div>
          </div></div>


                            <div class="form-group">
            <div class="checkbox">
             <label><input name="addThursdayCheck" id="addThursdayCheck" type="checkbox" value=true checked>Thursday</label>
                    <br>
                </div>
              </div>

          <div class="form-group">
            <div class="container">
                  <div class="row">
                  <div class='col-sm-6'>
                    Start
                  <div class='input-group date' id='addThursdayStartPicker'>
                    <input type='text' id="addStartThursday" name="addStartThursday" class="form-control" />
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-time"></span>
                  </div>
                  </div>
                  </div>
          </div></div>

                    <div class="form-group">
            <div class="container">
                  <div class="row">
                  <div class='col-sm-6'>
                    End
                  <div class='input-group date' id='addThursdayEndPicker'>
                    <input type='text' name="addEndThursday" id="addEndThursday" class="form-control" />
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-time"></span>
                  </div>
                  </div>
                  </div>
          </div></div>

                    <div class="form-group">
            <div class="checkbox">
             <label><input name="addFridayCheck" id="addFridayCheck" type="checkbox" value=true checked>Friday</label>
                    <br>
                </div>
              </div>

          <div class="form-group">
            <div class="container">
                  <div class="row">
                  <div class='col-sm-6'>
                    Start
                  <div class='input-group date' id='addFridayStartPicker'>
                    <input type='text' id="addStartFriday" name="addStartFriday" class="form-control" />
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-time"></span>
                  </div>
                  </div>
                  </div>
          </div></div>

                    <div class="form-group">
            <div class="container">
                  <div class="row">
                  <div class='col-sm-6'>
                    End
                  <div class='input-group date' id='addFridayEndPicker'>
                    <input type='text' name="addEndFriday" id="addEndFriday" class="form-control" />
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-time"></span>
                  </div>
                  </div>
                  </div>
          </div>
        </div>

          <div class="form-group">
            <input type="number" id="addlateArrival" class="form-control" name="addlateArrival" placeholder="Late Rrival" value="" required>
          </div>
          <div class="form-group">
            <input type="number" id="addearlyDeparture" class="form-control" name="addearlyDeparture" placeholder="Early Departure" value="" required>
          </div>
        
      </div>
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
@stop

@section('css')
    <script src='{{asset("vendor/adminlte/plugins/datatables/dataTables.bootstrap.css") }}'></script>
    <link rel="stylesheet" href='{{asset("css/bootstrap-datetimepicker.min.css" )}}'/>
@stop

@section('js')
<script type="text/javascript">

$(document).ready(function() {

    $('#addShift').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
    if(id == null)
    {
      $('#ShiftId').val(-1)
      $('#addShiftName').val('')

      $('#addSaturdayStartPicker').data("DateTimePicker").date('0')
      $('#addSaturdayEndPicker').data("DateTimePicker").date('0')

      $('#addSundayStartPicker').data("DateTimePicker").date('0')
      $('#addSundayEndPicker').data("DateTimePicker").date('0')

      $('#addMondayStartPicker').data("DateTimePicker").date('0')
      $('#addMondayEndPicker').data("DateTimePicker").date('0')

      $('#addTusedayStartPicker').data("DateTimePicker").date('0')
      $('#addTusedayEndPicker').data("DateTimePicker").date('0')

      $('#addWednesdayStartPicker').data("DateTimePicker").date('0')
      $('#addWednesdayEndPicker').data("DateTimePicker").date('0')

      $('#addThursdayStartPicker').data("DateTimePicker").date('0')
      $('#addThursdayEndPicker').data("DateTimePicker").date('0')

      $('#addFridayStartPicker').data("DateTimePicker").date('0')
      $('#addFridayEndPicker').data("DateTimePicker").date('0')

      $('#addlateArrival').val(0)
      $('#addearlyDeparture').val(0)

      return
    }
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead. 
      var modal = $(this)
        
        $('#ShiftId').val(window.Shift[id].id)
        $('#addShiftName').val(window.Shift[id].name)


        if(window.Shift[id].Saturday == true)
        {
          $('#addsaturdayCheck').prop( "checked", true )
          $("#addStartSaturday").prop("disabled", false)
          $("#addEndSaturday").prop("disabled", false)
          $('#addSaturdayStartPicker').data("DateTimePicker").date(window.Shift[id].StartSaturday.split(" ")[1])
          $('#addSaturdayEndPicker').data("DateTimePicker").date(window.Shift[id].EndSaturday.split(" ")[1])
        } 
        else
        {
          $('#addSaturdayStartPicker').data("DateTimePicker").date('0')
          $('#addSaturdayEndPicker').data("DateTimePicker").date('0')
          $('#addsaturdayCheck').prop( "checked", false )
          $("#addStartSaturday").prop("disabled", true)
          $("#addEndSaturday").prop("disabled", true)
        }

        if(window.Shift[id].Sunday == true)
        {
          $('#addSundayCheck').prop( "checked", true )
          $("#addStartSunday").prop("disabled", false)
          $("#addEndSunday").prop("disabled", false)
          $('#addSundayStartPicker').data("DateTimePicker").date(window.Shift[id].StartSunday.split(" ")[1])
          $('#addSundayEndPicker').data("DateTimePicker").date(window.Shift[id].EndSunday.split(" ")[1])
        } 
        else
        {
          $('#addSundayStartPicker').data("DateTimePicker").date('0')
          $('#addSundayEndPicker').data("DateTimePicker").date('0')
          $('#addSundayCheck').prop( "checked", false )
          $("#addStartSunday").prop("disabled", true)
          $("#addEndSunday").prop("disabled", true)
        }

                if(window.Shift[id].Monday == true)
        {
          $('#addMondayCheck').prop( "checked", true )
          $("#addStartMonday").prop("disabled", false)
          $("#addEndMonday").prop("disabled", false)
          $('#addMondayStartPicker').data("DateTimePicker").date(window.Shift[id].StartMonday.split(" ")[1])
          $('#addMondayEndPicker').data("DateTimePicker").date(window.Shift[id].EndMonday.split(" ")[1])
        } 
        else
        {
          $('#addMondayStartPicker').data("DateTimePicker").date('0')
          $('#addMondayEndPicker').data("DateTimePicker").date('0')
          $('#addMondayCheck').prop( "checked", false )
          $("#addStartMonday").prop("disabled", true)
          $("#addEndMonday").prop("disabled", true)
        }

                if(window.Shift[id].Tuseday == true)
        {
          $('#addTusedayCheck').prop( "checked", true )
          $("#addStartTuseday").prop("disabled", false)
          $("#addEndTuseday").prop("disabled", false)
          $('#addTusedayStartPicker').data("DateTimePicker").date(window.Shift[id].StartTuseday.split(" ")[1])
          $('#addTusedayEndPicker').data("DateTimePicker").date(window.Shift[id].EndTuseday.split(" ")[1])
        } 
        else
        {
          $('#addTusedayStartPicker').data("DateTimePicker").date('0')
          $('#addTusedayEndPicker').data("DateTimePicker").date('0')
          $('#addTusedayCheck').prop( "checked", false )
          $("#addStartTuseday").prop("disabled", true)
          $("#addEndTuseday").prop("disabled", true)
        }

                if(window.Shift[id].Wednesday == true)
        {
          $('#addWednesdayCheck').prop( "checked", true )
          $("#addStartWednesday").prop("disabled", false)
          $("#addEndWednesday").prop("disabled", false)
          $('#addWednesdayStartPicker').data("DateTimePicker").date(window.Shift[id].StartWednesday.split(" ")[1])
          $('#addWednesdayEndPicker').data("DateTimePicker").date(window.Shift[id].EndWednesday.split(" ")[1])
        } 
        else
        {
          $('#addWednesdayStartPicker').data("DateTimePicker").date('0')
          $('#addWednesdayEndPicker').data("DateTimePicker").date('0')
          $('#addWednesdayCheck').prop( "checked", false )
          $("#addStartWednesday").prop("disabled", true)
          $("#addEndWednesday").prop("disabled", true)
        }

                if(window.Shift[id].Thursday == true)
        {
          $('#addThursdayCheck').prop( "checked", true )
          $("#addStartThursday").prop("disabled", false)
          $("#addEndThursday").prop("disabled", false)
          $('#addThursdayStartPicker').data("DateTimePicker").date(window.Shift[id].StartThursday.split(" ")[1])
          $('#addThursdayEndPicker').data("DateTimePicker").date(window.Shift[id].EndThursday.split(" ")[1])
        } 
        else
        {
          $('#addThursdayStartPicker').data("DateTimePicker").date('0')
          $('#addThursdayEndPicker').data("DateTimePicker").date('0')
          $('#addThursdayCheck').prop( "checked", false )
          $("#addStartThursday").prop("disabled", true)
          $("#addEndThursday").prop("disabled", true)
        }

                if(window.Shift[id].Friday == true)
        {
          $('#addFridayCheck').prop( "checked", true )
          $("#addStartFriday").prop("disabled", false)
          $("#addEndFriday").prop("disabled", false)
          $('#addFridayStartPicker').data("DateTimePicker").date(window.Shift[id].StartFriday.split(" ")[1])
          $('#addFridayEndPicker').data("DateTimePicker").date(window.Shift[id].EndFriday.split(" ")[1])
        } 
        else
        {
          $('#addFridayStartPicker').data("DateTimePicker").date('0')
          $('#addFridayEndPicker').data("DateTimePicker").date('0')
          $('#addFridayCheck').prop( "checked", false )
          $("#addStartFriday").prop("disabled", true)
          $("#addEndFriday").prop("disabled", true)
        }

              $('#addlateArrival').val(window.Shift[id].lateArrival)
              $('#addearlyDeparture').val(window.Shift[id].earlyDeparture)
      });

$('#addSaturdayStartPicker').datetimepicker({
  format: 'LT',
});

$('#addSaturdayEndPicker').datetimepicker({
format: 'LT'
      });

$('#addsaturdayCheck').change(function(){
     $("#addStartSaturday").prop("disabled", !$(this).is(':checked'));
     $("#addEndSaturday").prop("disabled", !$(this).is(':checked'));
   });

$('#addSundayStartPicker').datetimepicker({
format: 'LT'
      });
$('#addSundayEndPicker').datetimepicker({
format: 'LT'
      });

$('#addSundayCheck').change(function(){
     $("#addStartSunday").prop("disabled", !$(this).is(':checked'));
     $("#addEndSunday").prop("disabled", !$(this).is(':checked'));
   });
$('#addMondayStartPicker').datetimepicker({
format: 'LT'
      });
$('#addMondayEndPicker').datetimepicker({
format: 'LT'
      });

$('#addMondayCheck').change(function(){
     $("#addStartMonday").prop("disabled", !$(this).is(':checked'));
     $("#addEndMonday").prop("disabled", !$(this).is(':checked'));
   });

$('#addWednesdayStartPicker').datetimepicker({
format: 'LT'
      });
$('#addWednesdayEndPicker').datetimepicker({
format: 'LT'
      });

$('#addWednesdayCheck').change(function(){
     $("#addStartWednesday").prop("disabled", !$(this).is(':checked'));
     $("#addEndWednesday").prop("disabled", !$(this).is(':checked'));
   });

$('#addTusedayStartPicker').datetimepicker({
format: 'LT'
      });
$('#addTusedayEndPicker').datetimepicker({
format: 'LT'
      });

$('#addTusedayCheck').change(function(){
     $("#addStartTuseday").prop("disabled", !$(this).is(':checked'));
     $("#addEndTuseday").prop("disabled", !$(this).is(':checked'));
   });

$('#addThursdayStartPicker').datetimepicker({
format: 'LT'
      });
$('#addThursdayEndPicker').datetimepicker({
format: 'LT'
      });

$('#addThursdayCheck').change(function(){
     $("#addStartThursday").prop("disabled", !$(this).is(':checked'));
     $("#addEndThursday").prop("disabled", !$(this).is(':checked'));
   });

$('#addFridayStartPicker').datetimepicker({
format: 'LT'
      });
$('#addFridayEndPicker').datetimepicker({
format: 'LT'
      });

$('#addFridayCheck').change(function(){
     $("#addStartFriday").prop("disabled", !$(this).is(':checked'));
     $("#addEndFriday").prop("disabled", !$(this).is(':checked'));
   });


});

</script>
<script src='{{asset("js/moment.min.js")}}'></script>
<script src='{{asset("js/bootstrap-datetimepicker.min.js")}}'></script>
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
