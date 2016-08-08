{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')
@extends('layouts.javascript')

@section('title', 'Forbidden')

@section('content_header')
    <h1 class="headline text-yellow">Forbidden Access</h1>
@stop

@section('content')
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
                <div class="box-header"></div>

                <div class="box-body">

        <section class="content">
          <div class="error-page">
            <h2 class="headline text-yellow"> 403</h2>
            <div class="error-content">
              <h3><i class="fa fa-warning text-yellow"></i> Oops! Page Forbidden.</h3>
              <p>
                
              </p>
            </div><!-- /.error-content -->
          </div><!-- /.error-page -->
        </section>


</div>
</div>
</div>
</div>
@stop