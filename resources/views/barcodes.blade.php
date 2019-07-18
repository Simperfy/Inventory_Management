@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '. 'reports')

@section('page_header')
  <div class="container-fluid">
    <h1 class="page-title">
      <i class=""></i> Print Barcodes
    </h1>
    @include('voyager::multilingual.language-selector')
  </div>
@stop

@section('content')
  <div class="page-content browse container-fluid">
    @include('voyager::alerts')
    <div class="row" id="app">
        <barcodes></barcodes>
    </div>
  </div>

@stop

@section('css')

@stop

@section('javascript')
@stop
