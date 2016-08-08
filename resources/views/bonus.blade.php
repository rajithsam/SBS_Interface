{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')
@extends('layouts.javascript')

@section('title', 'Bonus')

@section('content_header')
    <h1>Edit Bonus</h1>
@stop

@section('content')

    <div class="row">
      <div class="col-xs-12">
        <div class="box">
                <div class="box-header"></div>

                <div class="box-body">

                <div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    
                     <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#addBonus" data-whatever="@mdo"><span class="glyphicon glyphicon-plus"></span></button>

                    <table class="table table-bordered table-stripedss" id="dataTable" role="grid">
                        <thead>
                            <tr>
                                <th>ID<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Type<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Count<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Raise %<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Unit<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                       @for($i =0; $i < count($Bonus); $i++)
                        <tr>
                            <td>{{ $Bonus[$i]->id }}</td>
                            <td>{{ $Bonus[$i]->type }}</td>
                            <td>{{ $Bonus[$i]->maxNumber }}</td>
                            <td>{{ $Bonus[$i]->raise }}</td>

                            <td>{{ $Bonus[$i]->unit->name }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editBonus" data-id= {{ $i }} ><span class="glyphicon glyphicon-edit"></span></button>
                                <a class="btn btn-danger" href="delete/{{$Bonus[$i]->id}}" ><span class="glyphicon glyphicon-remove"></span></a>
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


<div class="modal fade" id="editBonus" tabindex="-1" role="dialog" aria-labelledby="editBonusLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editBonusLabel">Edit Bonus</h4>
      </div>
       <div class="modal-body">
      <form method="post" action='{{ action ('BonusController@update')}}'>
              <div class="form-group">
            <input id="editBonusName" class="form-control" name="editBonusName" placeholder="Bonus Name" value="" required>
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
            <input type="number" id="editraise" class="form-control" name="editraise" placeholder="raise %" value="" required>
          </div>

      </div>
      <div class="modal-footer">
        <input type="hidden" id="editBonusId" name="editBonusId" value="">
        {{ csrf_field() }}
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="addBonus" tabindex="-1" role="dialog" aria-labelledby="addBonusLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
               

      <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="editBonusLabel">Add Bonus</h4>
              </div>
      <div class="modal-body">
             <form method="post" role="form" action='{{ action ('BonusController@create')}}'>
              <div class="form-group">
            <input id="BonusName" class="form-control" name="BonusName" placeholder="Bonus Name" value="" required>
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
            <input type="number" id="raise" class="form-control" name="raise" placeholder="raise %" value="" required>
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
@stop

@section('css')
    <script src='{{asset("vendor/adminlte/plugins/datatables/dataTables.bootstrap.css") }}'></script>
@stop

@section('js')
<script type="text/javascript">
$('#editBonus').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead. 
      var modal = $(this)

        $('#editBonusId').val(window.Bonus[id].id)
        $('#editBonusName').val(window.Bonus[id].type)
        $('#editmaxNumber').val(window.Bonus[id].maxNumber)
        $('#editraise').val(window.Bonus[id].raise)
        $('#editunit').val(window.Bonus[id].unit_id).change();
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
@stop

