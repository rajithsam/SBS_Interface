{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')
@extends('layouts.javascript')

@section('title', 'Calendar')

@section('content_header')
    <h1>Holiday Calendar</h1>
@stop

@section('content')

    <div class="row">
      <div class="col-xs-12">
        <div class="box">
                <div class="box-header"></div>

                <div class="box-body">

                <div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                     <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#createEvent" ><span class="glyphicon glyphicon-plus"></span></button>
<br><br>
    {!! $calendar->calendar() !!}


<div class="modal fade" data-backdrop="static" data-keyboard="false" id="createEvent" tabindex="-1" role="dialog" aria-labelledby="editPermissionLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form method="post" action='{{ action ('CalendarController@createEvent')}}'>
      <div class="modal-header">
        <h4 class="modal-title" id="editPermissionLabel">
                  <div class="form-group">
        <input id="createEventName" name="createEventName" value="" class="form-control" placeholder="Event Name" required>
      </div>
        </h4>
      </div>

      <div class="modal-body">

    <div class="form-group">
      <label  class="col-sm-2 control-label">
    Start
  </label>
    <div class='input-group date' id='start'>
    <input type='text' id='startDateV'  name='startDateV' class="form-control" required/>
    <span class="input-group-addon">
    <span class="glyphicon glyphicon-calendar"></span>
    </span>
    </div>
    </div>

    <div class="form-group">
      <label  class="col-sm-2 control-label">
    End
  </label>
    <div class='input-group date' id='end'>

    <input type='text' class="form-control"  id='endDateV'  name='endDateV' required/>
    <span class="input-group-addon">
    <span class="glyphicon glyphicon-calendar"></span>
    </span>
    </div>
    </div>

    <div class="form-group">
        <div class="checkbox">
          <label><input id="FullDay" name="FullDay" type="checkbox" value=true>Full Day</label>
      </div>
        </div>

      </div>
      <div class="modal-footer">
        <div class="form-group">
        {{ csrf_field() }}
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="submit">Save</button>
      </div>
        </form>
      </div>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" data-backdrop="static" data-keyboard="false" id="myModal" tabindex="-1" role="dialog" aria-labelledby="editPermissionLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form method="post" action='{{ action ('CalendarController@updateEvent')}}'>
      <div class="modal-header">
        <h4 class="modal-title" id="editPermissionLabel">
        	        <div class="form-group">
        <input id="eventName" name="eventName" value="" class="form-control" placeholder="Event Name" required>
    	</div>
        </h4>
      </div>

      <div class="modal-body">
      	<div class="form-group">
        <input id="eventUpdatetId" name="eventUpdatetId" value="" type="hidden">
    	</div>



		<div class="form-group">
			<label  class="col-sm-2 control-label">
		Start
	</label>
		<div class='input-group date' id='startDate'>
		<input type='text' id='startDateValue'  name='startDateValue' class="form-control" required />
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

		<input type='text' class="form-control"  id='endDateValue'  name='endDateValue' required/>
		<span class="input-group-addon">
		<span class="glyphicon glyphicon-calendar"></span>
		</span>
		</div>
		</div>

		<div class="form-group">
        <div class="checkbox">
        	<label><input id="eventFullDay" name="eventFullDay" type="checkbox" value=true>Full Day</label>
    	</div>
        </div>

      </div>
      <div class="modal-footer">
      	<div class="form-group">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-primary" id="submit"><span class="glyphicon glyphicon-edit"></span></button>
    	</div>
        </form>

        <form method="post" action='{{ action ('CalendarController@deleteEvent')}}'>
        	<div class="form-group">
        	{{ csrf_field() }}
        <input id="eventDeleteId" name="eventDeleteId" value="" type="hidden">
        <button type="submit" class="btn btn-danger" id="submit"><span class="glyphicon glyphicon-remove"></span></button>
    	</div>
      </div>
      </form>
    </div>
  </div>
</div>

            </div>
        </div>
                </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href='{{asset("css/fullcalendar.min.css")}}'/>
<link rel="stylesheet" href='{{asset("css/bootstrap-datetimepicker.min.css" )}}'/>
@stop

@section('js')
    {!! $calendar->script() !!}

<script type="text/javascript">

$(document).ready(function() {

    $('#start').datetimepicker();
  $('#end').datetimepicker();

if(window.location.href.indexOf('#myModal') != -1) {
	$('#startDate').datetimepicker({
		defaultDate : Date.parse(window.events.start)
	});
	$('#endDate').datetimepicker({
		defaultDate : Date.parse(window.events.end)
	});

  $('#myModal').modal('show');
  $('#eventUpdatetId').val(window.events.id)
  $('#eventName').val(window.events.title)
  if(window.events.fullDay==true)
  	 $('#eventFullDay').prop( "checked", true )
  else
  	$('#eventFullDay').prop( "checked", false )

  $('#eventDeleteId').val(window.events.id)
    }
});

</script>
<script src='{{asset("js/moment.min.js")}}'></script>
<script src='{{asset("js/fullcalendar.min.js")}}'></script>
<script src='{{asset("js/bootstrap-datetimepicker.min.js")}}'></script>

@stop