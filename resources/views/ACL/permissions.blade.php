{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')
@extends('layouts.javascript')

@section('title', 'Permissions')

@section('content_header')
    <h1>{{trans('suprema.Edit')}} {{trans('suprema.Permissions') }}</h1>
@stop

@section('content')

    <div class="row">
      <div class="col-xs-12">
        <div class="box">
                <div class="box-header"></div>

                <div class="box-body">

                <div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    
                     <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#addPermission" data-whatever="@mdo"><span class="glyphicon glyphicon-plus"></span></button>

                    <table class="table table-bordered table-stripedss" id="dataTable" role="grid">
                        <thead>
                            <tr>
                                <th>{{trans('suprema.ID')}}<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>{{trans('suprema.Name')}}<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>{{trans('suprema.Created_By')}}<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>{{trans('suprema.IP')}}<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>{{trans('suprema.Created_At')}}<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>{{trans('suprema.Updated_At')}}<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>{{trans('suprema.Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                       @for($i =0; $i < count($Permissions); $i++)
                        <tr>
                            <td>{{ $Permissions[$i]->id }}</td>
                            <td>{{ $Permissions[$i]->name }}</td>
                            <td>{{ $Permissions[$i]->created_by_user }}</td>
                            <td>{{ $Permissions[$i]->created_from_ip }}</td>
                            <td>{{ $Permissions[$i]->created_at }}</td>
                            <td>{{ $Permissions[$i]->updated_at }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editPermission" data-id= {{ $i }} ><span class="glyphicon glyphicon-edit"></span></button>
                                <a class="btn btn-danger" href="deletePermission/{{$Permissions[$i]->id}}" ><span class="glyphicon glyphicon-remove"></span></a>
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


<div class="modal fade" id="editPermission" tabindex="-1" role="dialog" aria-labelledby="editPermissionLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editPermissionLabel"></h4>
      </div>
      <form method="post" action='{{ action ('ACLController@updatePermission')}}'>
      <div class="modal-body">
        
            <div class="form-group">
                <div class="checkbox">
                    @foreach($Views as $view)
                    <label><input name="views[]" id={{ $view->id }} type="checkbox" value="{{ $view->id }}"/>{{ $view->path }}</label>
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

<div class="modal fade" id="addPermission" tabindex="-1" role="dialog" aria-labelledby="addPermissionLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form method="post" action='{{ action ('ACLController@addPermission')}}'>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <input id="permissionName" class="form-control" name="permissionName" placeholder="Permission Name" value="">
      </div>
      <div class="modal-body">
        
            <div class="form-group">
                <div class="checkbox">
                    @foreach($Views as $view)
                    <label><input name="views[]" id={{ $view->id }} type="checkbox" value="{{ $view->id }}" />{{ $view->path }}</label>
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
@stop

@section('css')
    <script src='{{asset("vendor/adminlte/plugins/datatables/dataTables.bootstrap.css") }}'></script>
@stop

@section('js')
<script>
$('#editPermission').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead. 
      var modal = $(this)
        modal.find('.modal-title').text("Edit Permission - " + window.Permissions[id].name)

        $('#PermissionId').val(window.Permissions[id].id)
        for(i=0 ; i < window.Views.length ; i++)
        {
            $('#' + window.Views[i].id).prop( "checked", false )
        }
        for(i=0 ; i < window.Permissions[id].views.length ; i++)
        {
            $('#' + window.Permissions[id].views[i].id).prop( "checked", true )
        }
          
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
