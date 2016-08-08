{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')
@extends('layouts.javascript')

@section('title', 'Abscents')

@section('content_header')
    <h1>Edit Abscents</h1>
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

                       @for($i =0; $i < count($Abscent); $i++)
                        <tr>
                            <td>{{ $Abscent[$i]->id }}</td>
                            <td>{{ $Abscent[$i]->employee->name }}</td>
                            <td>{{ $Abscent[$i]->startDate }}</td>
                            <td>{{ $Abscent[$i]->endDate }}</td>
                            @if($approve)
                            <td>{{ $Abscent[$i]->leave->type }}</td>
                            <td>{{ $Abscent[$i]->approver->name }}</td>
                            <td>{{ $Abscent[$i]->approved_from_ip }}</td>
                            <td>{{ $Abscent[$i]->note}}</td>
                            @endif
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editAbscent" data-id= {{ $i }} ><span class="glyphicon glyphicon-ok"></span></button>
                            </td>
                        </tr>
                        @endfor
                    </table>

                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="editAbscent" tabindex="-1" role="dialog" aria-labelledby="editAbscentLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editAbscentLabel">Edit Abscent</h4>
      </div>
       <div class="modal-body">
      <form method="post" action='{{ action ('AbscentController@update')}}' role="form">
          <div class="form-group">
            <textarea rows= "5" id="editAbscentNote" class="form-control" name="editAbscentNote" placeholder="Abscent Note" value="" required>
            </textarea>
          </div>

         <div class="form-group">
            Leave Type 
          <select class="form-controll" id="leave" name="leave" required>
            @foreach($Leaves as $leave)
            <option value={{ $leave->id }} >{{ $leave->type }}</option>
            @endforeach
              </select>
            </div>

      </div>
      <div class="modal-footer">
        <input type="hidden" id="editAbscentId" name="editAbscentId" value="">
        <input type="hidden" id="editAbscentApproved" name="editAbscentApproved" value="true">
        {{ csrf_field() }}
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Approve</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
@stop

@section('css')
    <script src='{{asset("vendor/adminlte/plugins/datatables/dataTables.bootstrap.css") }}'></script>
@stop

@section('js')
<script type="text/javascript">
$('#editAbscent').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead. 
      var modal = $(this)

        $('#editAbscentId').val(window.Abscent[id].id)
        $('#editAbscentNote').val(window.Abscent[id].note);

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


