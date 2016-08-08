{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')
@extends('layouts.javascript')

@section('title', 'Leaves')

@section('content_header')
    <h1>Edit Leaves</h1>
@stop

@section('content')

    <div class="row">
      <div class="col-xs-12">
        <div class="box">
                <div class="box-header"></div>

                <div class="box-body">

                <div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    
                     <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#addLeave" data-whatever="@mdo"><span class="glyphicon glyphicon-plus"></span></button>

                    <table class="table table-bordered table-stripedss" id="dataTable" role="grid">
                        <thead>
                            <tr>
                                <th>ID<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Type<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Count<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Deduction %<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Parent<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Unit<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                       @for($i =0; $i < count($Leave); $i++)
                        <tr>
                            <td>{{ $Leave[$i]->id }}</td>
                            <td>{{ $Leave[$i]->type }}</td>
                            <td>{{ $Leave[$i]->maxNumber }}</td>
                            <td>{{ $Leave[$i]->deduction }}</td>
                            
                            <td>
                              @if ($Leave[$i]->leave_id)
                              {{ $Leave[$i]->leave_id }}
                              @endif
                            </td>

                            <td>{{ $Leave[$i]->unit->name }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editLeave" data-id= {{ $i }} ><span class="glyphicon glyphicon-edit"></span></button>
                                <a class="btn btn-danger" href="delete/{{$Leave[$i]->id}}" ><span class="glyphicon glyphicon-remove"></span></a>
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


<div class="modal fade" id="editLeave" tabindex="-1" role="dialog" aria-labelledby="editLeaveLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editLeaveLabel">Edit Leave</h4>
      </div>
       <div class="modal-body">
      <form method="post" action='{{ action ('LeaveController@update')}}'>
              <div class="form-group">
            <input id="editLeaveName" class="form-control" name="editLeaveName" placeholder="Leave Name" value="" required>
          </div>
          <div class="form-group">
            <input type="number" id="editmaxNumber" class="form-control" name="editmaxNumber" placeholder="Count" value="" required>
          </div>

          <div class="form-group">
            Unit 
          <select class="selectpicker" id="editunit" name="editunit" required>
            @foreach($units as $unit)
            <option value={{ $unit->id }}>{{ $unit->name }}</option>
            @endforeach
              </select>
            </div>

           <div class="form-group">
            <input type="number" id="editdeduction" class="form-control" name="editdeduction" placeholder="Deduction %" value="" required>
          </div>

          <div class="form-group">
            <div class="checkbox">
             <label><input name="editparentCheck" id="editparentCheck" type="checkbox" value=true checked>Parent</label>
                    <br>
                </div>
              </div>
          <div class="form-group"> 
          <select class="selectpicker" id="editparent" name="editparent">
            @foreach($Leave as $key)
            <option value={{ $key->id }}>{{ $key->type }}</option>
            @endforeach
              </select>
            </div>

      </div>
      <div class="modal-footer">
        <input type="hidden" id="editLeaveId" name="editLeaveId" value="">
        {{ csrf_field() }}
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="addLeave" tabindex="-1" role="dialog" aria-labelledby="addLeaveLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
               

      <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="editLeaveLabel">Add Leave</h4>
              </div>
      <div class="modal-body">
             <form method="post" action='{{ action ('LeaveController@create')}}'>
              <div class="form-group">
            <input id="LeaveName" class="form-control" name="LeaveName" placeholder="Leave Name" value="" required>
          </div>
          <div class="form-group">
            <input type="number" id="maxNumber" class="form-control" name="maxNumber" placeholder="Count" value="" required>
          </div>

          <div class="form-group">
            Unit 
          <select class="selectpicker" id="unit" name="unit" required>
            @foreach($units as $unit)
            <option value={{ $unit->id }}>{{ $unit->name }}</option>
            @endforeach
              </select>
            </div>

           <div class="form-group">
            <input type="number" id="deduction" class="form-control" name="deduction" placeholder="Deduction %" value="" required>
          </div>

          <div class="form-group">
            <div class="checkbox">
             <label><input name="parentCheck" id="parentCheck" type="checkbox" value=true checked>Parent</label>
                    <br>
                </div>
              </div>
          <div class="form-group"> 
          <select class="selectpicker" id="parent" name="parent">
            @foreach($Leave as $key)
            <option value={{ $key->id }}>{{ $key->type }}</option>
            @endforeach
              </select>
            </div>

      </div>
      <div class="modal-footer">
        {{ csrf_field() }}
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="submit" name="submit">Save</button>
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
$('#editLeave').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead. 
      var modal = $(this)

        $('#editLeaveId').val(window.Leave[id].id)
        $('#editLeaveName').val(window.Leave[id].type)
        $('#editmaxNumber').val(window.Leave[id].maxNumber)
        $('#editdeduction').val(window.Leave[id].deduction)
        $('#editunit').val(window.Leave[id].unit_id).change();
        if(window.Leave[id].leave_id > 0)
          $('#editparent').val(window.Leave[id].leave_id).change();
        else
          $("#editparentCheck").prop("checked", false);
      });

$('#parentCheck').change(function(){
     $("#parent").prop("disabled", !$(this).is(':checked'));
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
@endsection
