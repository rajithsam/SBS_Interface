{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')
@extends('layouts.javascript')

@section('title', 'Event Log')

@section('content_header')
    <h1>Event Log</h1>
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
                                <th>Terminal Number<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Time<span class="glyphicon glyphicon-sort pull-right"></span></th>
                                <th>Event<span class="glyphicon glyphicon-sort pull-right"></span></th>
                            </tr>
                        </thead>
                    <tbody>
                       @for($i =0; $i < count($Employee->Events); $i++)
                        <tr>
                            <td>{{ $Employee->Events[$i]->nEventLogIdn }}</td>
                            <td>{{ $Employee->Events[$i]->nReaderIdn }}</td>
                            <td>{{ date('m/d/Y H:i:s' ,$Employee->Events[$i]->nDateTime)}}</td>
                            <td>
                            @if($Employee->Events[$i]->nTNAEvent == 0)
                                Check In
                            @endif
                            @if($Employee->Events[$i]->nTNAEvent == 1)
                                Check Out
                            @endif
                            @if($Employee->Events[$i]->nTNAEvent == 255)
                                Enroll Success
                            @endif
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

@stop

@section('css')
    <script src='{{asset("vendor/adminlte/plugins/datatables/dataTables.bootstrap.css") }}'></script>
@stop

@section('js')
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