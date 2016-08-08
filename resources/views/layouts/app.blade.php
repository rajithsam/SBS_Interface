{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop

@section('css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
@stop

@section('js')
    <!-- JavaScripts -->   
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>-->
    <script type="text/javascript">
    $.ajaxSetup({
    headers: {
            'X-CSvRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    </script>
@stop
