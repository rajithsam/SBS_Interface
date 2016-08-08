{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')
@extends('layouts.javascript')

@section('title', 'Employees')

@section('content_header')
    <h1>Edit Employees</h1>
@stop

@section('content')

    <div class="row">
      <div class="col-xs-12">
        <div class="box">
                <div class="box-header"></div>

                <div class="box-body">

                <div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                     <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#addEmployee" data-whatever="@mdo"><span class="glyphicon glyphicon-plus"></span></button>

                    <table class="table table-bordered table-stripedss" id="dataTable" role="grid">
                        <thead>
                            <tr>
                                <th>ID<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Name<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Phone<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Card Number<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Department<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                       @for($i =0; $i < count($Employee); $i++)
                        <tr>
                            <td>{{ $Employee[$i]->id }}</td>
                            <td>{{ $Employee[$i]->name }}</td>
                            <td>{{ $Employee[$i]->phone }}</td>
                            <td>{{ $Employee[$i]->card_number }}</td>
                            <td>{{ $Employee[$i]->department->name }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editEmployee" data-id= {{ $i }} ><span class="glyphicon glyphicon-edit"></span></button>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#devices" data-id= {{ $i }} ><span class="glyphicon glyphicon-hand-up"></span></button>
                                <a class="btn btn-warning" href="/ShiftAssignment/index/{{$Employee[$i]->id}}" ><span class="glyphicon glyphicon-file"></span></a>
                                <a class="btn btn-danger" href="delete/{{$Employee[$i]->id}}" ><span class="glyphicon glyphicon-remove"></span></a>
                            </td>
                        </tr>
                        @endfor
                      </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="devices" tabindex="-1" role="dialog" aria-labelledby="devices">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="ChooseDevice">Choose Device</h4>
      </div>
      <div class="modal-body">
             <form method="post" action='{{ action ('EmployeeController@enrollFinger')}}'>

          <div class="form-group">
            Device 
          <select class="selectpicker" id="nDevice" name="nDevice" required>
            @foreach($Devices as $device)
            <option value={{ $device[0] }}>{{ $device[0] }}</option>
            @endforeach
              </select>
            </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="nID" name="nID" value="">
        <input type="hidden" id="nName" name="nName" value="">
        {{ csrf_field() }}
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Enroll</button>
      </div>
      </form>
    
  </div>
</div></div></div>

<div class="modal fade" id="addEmployee" tabindex="-1" role="dialog" aria-labelledby="addEmployeeLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
               

      <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="editEmployeeLabel">Add Employee</h4>
              </div>
      <div class="modal-body">
             <form method="post" action='{{ action ('EmployeeController@create')}}'>
              <div class="form-group">
       <input id="EmployeeName" class="form-control" name="EmployeeName" placeholder="Employee Name" value="">
        </div>
        <div class="form-group">
        <input type="number" id="phone" class="form-control" name="phone" placeholder="Phone" value="">
      </div>

       <div class="form-group">
        <input type="number" id="card_number" class="form-control" name="card_number" placeholder="Card Number" value="">
      </div>
      <div class="form-group">
        <input type="number" id="nUserID" required class="form-control" name="nUserID" placeholder="Device Finger ID" value="">
      </div>
      
          <div class="form-group">
            Departments 
          <select class="selectpicker" name="department_id" required>
            @foreach($departments as $department)
            <option value={{ $department->id }}>{{ $department->name }}</option>
            @endforeach
              </select>
            </div>


       <div class="form-group">
        <input type="number" id="salary" class="form-control" name="salary" placeholder="Salary" value="">
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
</div>

<div class="modal fade" id="editEmployee" tabindex="-1" role="dialog" aria-labelledby="editEmployeeLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editEmployeeLabel">Edit Employee</h4>
      </div>
      <div class="modal-body">
             <form method="post" action='{{ action ('EmployeeController@update')}}'>
              <div class="form-group">
       <input id="editEmployeeName" class="form-control" name="editEmployeeName" placeholder="Employee Name" value="">
        </div>
        <div class="form-group">
        <input type="number" id="editphone" class="form-control" name="editphone" placeholder="Phone" value="">
      </div>

       <div class="form-group">
        <input type="number" id="editcard_number" class="form-control" name="editcard_number" placeholder="Card Number" value="">
      </div>
            <div class="form-group">
        <input type="number" id="edit_nUserID" class="form-control" name="edit_nUserID" placeholder="Device Finger ID" value="">
      </div>
          <div class="form-group">
            Departments 
          <select class="selectpicker" id="editdepartment_id" name="editdepartment_id" required>
            @foreach($departments as $department)
            <option value={{ $department->id }}>{{ $department->name }}</option>
            @endforeach
              </select>
            </div>


       <div class="form-group">
        <input type="number" id="editsalary" class="form-control" name="editsalary" placeholder="Salary" value="">
      </div>
      <div class="modal-footer">
        <input type="hidden" id="EmployeeId" name="EmployeeId" value="">
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
@stop

@section('js')
<script type="text/javascript">
$('#devices').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead. 
    var modal = $(this)
    $('#nID').val(window.Employee[id].nUserID)
    $('#nName').val(window.Employee[id].name)
})

$('#editEmployee').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead. 
      var modal = $(this)

        $('#EmployeeId').val(window.Employee[id].id)
        $('#editEmployeeName').val(window.Employee[id].name)
        $('#editphone').val(window.Employee[id].phone)
        $('#editcard_number').val(window.Employee[id].card_number)
        $('#edit_nUserID').val(window.Employee[id].nUserID)
        $('#editsalary').val(window.Employee[id].salary)
        $('#editdepartment_id').val(window.Employee[id].department.id).change(); 
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
