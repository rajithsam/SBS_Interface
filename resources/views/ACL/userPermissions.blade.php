{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')
@extends('layouts.javascript')

@section('title', 'Users')

@section('content_header')
    <h1>{{trans('suprema.Edit')}} {{trans('suprema.Users') }}</h1>
@stop

@section('content')

        <div class="box">
                <div class="box-header"></div>

                <div class="box-body">

                <div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    

                <div class="box-body table-responsive no-padding">
                     <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#addUserPermission" data-whatever="@mdo"><span class="glyphicon glyphicon-plus"></span></button>

                    <table class="table table-bordered table-stripedss" id="dataTable" role="grid">
                        <thead>
                            <tr>
                                <th>{{trans('suprema.ID')}}<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>{{trans('suprema.Name')}}<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>{{trans('suprema.Email')}}<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>{{trans('suprema.Created_At')}}<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>{{trans('suprema.Updated_At')}}<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>{{trans('suprema.Actions')}}<span class="glyphicon glyphicon-sort pull-right"></span></th>
                            </tr>
                        </thead>
                        <tbody>
                       @for($i =0; $i < count($Permissions); $i++)
                        <tr>
                            <td>{{ $Permissions[$i]->id }}</td>
                            <td>{{ $Permissions[$i]->name }}</td>
                            <td>{{ $Permissions[$i]->email}}</td>
                            <td>{{ $Permissions[$i]->created_at }}</td>
                            <td>{{ $Permissions[$i]->updated_at }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editUser" data-id= {{ $i }} ><span class="glyphicon glyphicon-edit"></span></button>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editUserPermission" data-id= {{ $i }} ><span class="glyphicon glyphicon-lock"></span></button>
                                <a class="btn btn-danger" href="deleteUserPermission/{{$Permissions[$i]->id}}" ><span class="glyphicon glyphicon-remove"></span></a>
                            </td>
                        </tr>
                        @endfor
                      </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>


<div class="modal fade" id="editUserPermission" tabindex="-1" role="dialog" aria-labelledby="editUserPermissionLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editUserPermissionLabel"></h4>
      </div>
      <form method="post" action='{{ action ('ACLController@updateUserPermission')}}'>
      <div class="modal-body">
        
            <div class="form-group">
                <div class="checkbox">
                    @foreach($Views as $view)
                    <label><input name="views[]" id={{ $view->id }} type="checkbox" value="{{ $view->id }}"/>{{ $view->name }}</label>
                    <br>
                    @endforeach
                </div>
            </div>
        
      </div>
      <div class="modal-footer">
        <input type="hidden" id="PermissionId" name="PermissionId" value="">
        {{ csrf_field() }}
        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('suprema.Close')}}</button>
        <button type="submit" class="btn btn-primary" id="submit" name="submit">{{trans('suprema.Save')}}</button>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="editUserLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editUserLabel">Edit User</h4>
      </div>
      <form method="post" id="editUserForm" action='{{ action ('ACLController@editUser')}}'
              data-fv-framework="bootstrap"
        data-fv-icon-valid="glyphicon glyphicon-ok"
        data-fv-icon-invalid="glyphicon glyphicon-remove"
        data-fv-icon-validating="glyphicon glyphicon-refresh">
      <div class="modal-body">

            <div class="form-group">
            <input type="text" id="name" name="name" class="form-control input-lg" placeholder="Name" required>
            </div>
            <div class="form-group">
            <input type="email" id="email" name="email" class="form-control input-lg" placeholder="Email"
            data-error="Email address is invalid" required>
            </div>
            <div class="checkbox">
             <label><input name="changePassword" id="changePassword" type="checkbox" value="changePassword">Change Password</label>
                    <br>
                </div>


            <div class="form-group">
            <input type="password" id="password" name="password" class="form-control input-lg" name="password" placeholder="Password" 
            minlength="9"
            required disabled>
            </div>
              <div class="form-group">
            <input type="password" id="confirmPassword" class="form-control input-lg" name="confirmPassword" placeholder="Confirm Password"
            data-fv-identical="true"
            data-fv-identical-field="password"
            data-fv-identical-message="The password and its confirm are not the same"
            required disabled
            >

          </div>
                        <div class="checkbox">
             <label><input name="isActive" id="isActive" type="checkbox" value=true>Active</label>
                    <br>
                </div>
                        <div class="checkbox">
             <label><input name="isSuperUser" id="isSuperUser" type="checkbox" value=true>Super User</label>
                    <br>
                </div>
            </div>
      <div class="modal-footer">
        <input type="hidden" id="userId" name="userId" value="">
        {{ csrf_field() }}
        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('suprema.Close')}}</button>
        <button type="submit" class="btn btn-primary">{{trans('suprema.Save')}}</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="addUserPermission" tabindex="-1" role="dialog" aria-labelledby="addUserPermissionLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form method="post" id ="addUserForm" action='{{ action ('ACLController@addUser')}}'
        data-fv-framework="bootstrap"
        data-fv-icon-valid="glyphicon glyphicon-ok"
        data-fv-icon-invalid="glyphicon glyphicon-remove"
        data-fv-icon-validating="glyphicon glyphicon-refresh"
     >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addUser">New User</h4>
      </div>
      <div class="modal-body">

      <div class="row text-center">
      </div>
      <hr />
      <div class="form-group">
      <input type="text" name="name" class="form-control input-lg" placeholder="Name" required>
      </div>
      <div class="form-group">
      <input type="email" name="email" class="form-control input-lg" placeholder="Email"
      data-error="Email address is invalid" required>
      </div>
      <div class="form-group">
      <input type="password" name="password" class="form-control input-lg" name="password" placeholder="Password" 
      minlength="9"
      required>
      </div>
      <div class="form-group">
      <input type="password" class="form-control input-lg" name="confirmPassword" placeholder="Confirm Password"
        data-fv-identical="true"
        data-fv-identical-field="password"
        data-fv-identical-message="The password and its confirm are not the same"
        required
      >
      <div class="checkbox">
      <label><input name="isActive" id="isActive" type="checkbox" value=true checked>Active</label>
      <br>
      </div>
      <div class="checkbox">
      <label><input name="isSuperUser" id="isSuperUser" type="checkbox" value=true>Super User</label>
      <br>
      </div>
      </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="PermissionId" name="PermissionId" value="">
        {{ csrf_field() }}
        <div class="form-actions">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('suprema.Close')}}</button>
        <button type="submit" class="btn btn-primary">{{trans('suprema.Save')}}</button>
      </div>
      </div>
      </form>
    </div>
  </div>
</div>
@stop

@section('css')
    <script src='{{asset("vendor/adminlte/plugins/datatables/dataTables.bootstrap.css") }}'></script>
    <script src='{{asset("formvalidation/css/formValidation.min.css") }}'></script>
@stop

@section('js')
<script type="text/javascript" src= '{{asset("formvalidation/js/formValidation.min.js")}}'></script>
<script type="text/javascript" src= '{{asset("formvalidation/js/framework/bootstrap.min.js")}}'></script>
<script>
$('#editUserPermission').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead. 
      var modal = $(this)
        modal.find('.modal-title').text("Edit Permission - " + window.Permissions[id].name)

        $('#PermissionId').val(window.Permissions[id].id)

        for(i=0 ; i < Views.length ; i++)
        {
            $('#' + Views[i].id).prop( "checked", false )
        }
        for(i=0 ; i < window.Permissions[id].permissions.length ; i++)
        {
            $('#' +window.Permissions[id].permissions[i].id).prop( "checked", true )
        }
          
      })

$('#editUser').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead. 
      var modal = $(this)
        modal.find('.modal-title').text("Edit User - " + window.Permissions[id].id)

        $('#userId').val(window.Permissions[id].id)
        $('#name').val(window.Permissions[id].name)
        $('#email').val(window.Permissions[id].email)

        if(window.Permissions[id].isSuperUser == true)
          $('#isSuperUser').prop( "checked", true )
        if(window.Permissions[id].isActive == true)
          $('#isActive').prop( "checked", true )
          
      })
</script>
<script>
$(document).ready(function() {
      $('#addUserForm').formValidation()
      $('#editUserForm').formValidation()
 });
$('#changePassword').change(function(){
     $("#password").prop("disabled", !$(this).is(':checked'));
     $("#confirmPassword").prop("disabled", !$(this).is(':checked'));
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
