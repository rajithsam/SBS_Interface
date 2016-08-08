{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')
@extends('layouts.javascript')

@section('title', 'Departments')

@section('content_header')
    <h1>Edit Departments</h1>
@stop

@section('content')

    <div class="row">
      <div class="col-xs-12">
        <div class="box">

                <div class="box-header"></div>

                <div class="box-body">
                <div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    

                     <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#addDepartment" data-whatever="@mdo"><span class="glyphicon glyphicon-plus"></span></button>
                    <table class="table table-bordered table-stripedss" id="dataTable" role="grid">
                        <thead>
                            <tr>
                                <th>ID<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Name<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                       @for($i =0; $i < count($Department); $i++)
                        <tr>
                            <td>{{ $Department[$i]->id }}</td>
                            <td>{{ $Department[$i]->name }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editDepartment" data-id= {{ $i }} ><span class="glyphicon glyphicon-edit"></span></button>
                                <a class="btn btn-danger" href="delete/{{$Department[$i]->id}}" ><span class="glyphicon glyphicon-remove"></span></a>
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


<div class="modal fade" id="editDepartment" tabindex="-1" role="dialog" aria-labelledby="editDepartmentLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editDepartmentLabel">Edit Department</h4>
      </div>
       <div class="modal-body">
      <form method="post" action='{{ action ('DepartmentController@update')}}'>

             <input id="editDepartmentName" name="editDepartmentName" value="" class="form-control" placeholder="Department Name" required>
        
        
      </div>
      <div class="modal-footer">
        <input type="hidden" id="DepartmentId" name="DepartmentId" value="">
        {{ csrf_field() }}
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="addDepartment" tabindex="-1" role="dialog" aria-labelledby="addDepartmentLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
               

      <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="editDepartmentLabel">Add Department</h4>
              </div>
      <div class="modal-body">
             <form method="post" action='{{ action ('DepartmentController@create')}}'>
            <input id="DepartmentName" class="form-control" name="DepartmentName" placeholder="Department Name" value="">

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
$('#editDepartment').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead. 
      var modal = $(this)

        $('#DepartmentId').val(window.Department[id].id)
        $('#editDepartmentName').val(window.Department[id].name)
          
      })
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
