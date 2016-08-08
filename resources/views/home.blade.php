@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-yellow">
<div class="inner">
  <h3>{{$numEmp}}</h3>
  <p>Present Employee</p>
</div>
<div class="icon">
  <i class="ion ion-person-add"></i>
</div>
<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>

<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-red">
<div class="inner">
<h3>{{$numAbs}}</h3>
<p>Unapproved Abscents</p>
</div>
<div class="icon">
<i class="ion ion-stats-bars"></i>
</div>
<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>

<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-green">
<div class="inner">
<h3>{{$numOve}}</h3>
<p>Unapproved Overtime</p>
</div>
<div class="icon">
<i class="ion ion-stats-bars"></i>
</div>
<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>

<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-blue">
<div class="inner">
<h3>{{$numDev}}</h3>
<p>Connected Devices</p>
</div>
<div class="icon">
<i class="ion ion-pie-graph"></i>
</div>
<a href="/ConnectedDevices" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>
@stop