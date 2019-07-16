{{--<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Sales Report</title>
</head>
<body>
<div id="app">
  <chart></chart>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>--}}

@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '. 'reports')

@section('page_header')
  <div class="container-fluid">
    <h1 class="page-title">
      <i class=""></i> Sales Report
    </h1>
    @include('voyager::multilingual.language-selector')
  </div>
@stop

@section('content')
  <div class="page-content browse container-fluid">
    @include('voyager::alerts')
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-bordered">
          <div class="panel-body" id="app">
            <chart></chart>
          </div>
        </div>
      </div>
    </div>
  </div>

@stop

@section('css')

@stop

@section('javascript')
@stop
