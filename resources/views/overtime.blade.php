{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')
@extends('layouts.javascript')

@section('title', 'Overtime')

@section('content_header')
    <h1>Edit Overtime</h1>
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
                                <th>Start<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>End<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                @if($approve)
                                <th>Type<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>By User<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>From IP<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Note<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                @endif
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                       @for($i =0; $i < count($Overtime); $i++)
                        <tr>
                            <td>{{ $Overtime[$i]->id }}</td>s
                            <td>{{ $Overtime[$i]->employee->name }}</td>
                            <td>{{ $Overtime[$i]->startDate }}</td>
                            <td>{{ $Overtime[$i]->endDate }}</td>
                            @if($approve)
                            <td>{{ $Overtime[$i]->bonus->type }}</td>
                            <td>{{ $Overtime[$i]->approver->name }}</td>
                            <td>{{ $Overtime[$i]->approved_from_ip }}</td>
                            <td>{{ $Overtime[$i]->note}}</td>
                            @endif
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editOvertime" data-id= {{ $i }} ><span class="glyphicon glyphicon-ok"></span></button>
                            </td>
                        </tr>
                        @endfor
                      </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    
<div class="modal fade" id="editOvertime" tabindex="-1" role="dialog" aria-labelledby="editOvertimeLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editOvertimeLabel">Edit Overtime</h4>
      </div>
       <div class="modal-body">
      <form method="post" action='{{ action ('OvertimeController@update')}}'>
          <div class="form-group">
            <textarea class="form-control" rows="5"  id="editOvertimeNote" class="form-control" name="editOvertimeNote" placeholder="Overtime Note" value="" required>            
            </textarea>
          </div>

         <div class="form-group">
            Bonus Type 
          <select class="selectpicker" id="bonus" name="bonus" required>
            @foreach($Bonuss as $Bonus)
            <option value={{ $Bonus->id }}>{{ $Bonus->type }}</option>
            @endforeach
              </select>
            </div>

      </div>
      <div class="modal-footer">
        <input type="hidden" id="editOvertimeId" name="editOvertimeId" value="">
        <input type="hidden" id="editOvertimeApproved" name="editOvertimeApproved" value="true">
        {{ csrf_field() }}
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Approve</button>
      </div>
      </form>
    </div>
  </div>
</div>
@stop
@section('css')
    <script src='{{asset("vendor/adminlte/plugins/datatables/dataTables.bootstrap.css") }}'></script>
@stop

@section('js')
<script type="text/javascript">
$('#editOvertime').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead. 
      var modal = $(this)

        $('#editOvertimeId').val(window.Overtime[id].id)
      });
</script>
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
