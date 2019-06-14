@php
  $edit = !is_null($dataTypeContent->getKey());
  $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->display_name_singular)

@section('page_header')
  <h1 class="page-title">
    <i class="{{ $dataType->icon }}"></i>
    {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->display_name_singular }}
  </h1>
  @include('voyager::multilingual.language-selector')
@stop

@section('content')
  <div class="page-content edit-add container-fluid" id="app">
    <form role="form" class="form-edit-add" action="{{ route('voyager.sales.store') }}" method="POST">
      @csrf
      <add-sale-component></add-sale-component>
    </form>

    {{--<div class="row">--}}

      {{--<div class="col-md-12">--}}
        {{--<div class="panel panel-bordered">--}}
          <!-- form start -->
          {{--<form role="form" class="form-edit-add" action="http://127.0.0.1:8000/admin/sales" method="POST">--}}
            <!-- PUT Method if we are editing -->

            <!-- CSRF TOKEN -->
            {{--@csrf--}}

            {{--<div class="panel-body">--}}
              <!-- Adding / Editing -->
              <!-- GET THE DISPLAY OPTIONS -->
              {{--<div class="form-group  col-md-12 ">--}}
                {{--<label class="control-label" for="name">Amount</label>--}}
              {{--</div>--}}

              <!-- GET THE DISPLAY OPTIONS -->
              {{--<div class="form-group  col-md-12 ">--}}
                {{--<label class="control-label" for="name">Amount Paid</label>--}}
                {{--<input type="number" class="form-control" name="amount_paid" required="" step="any"--}}
                       {{--placeholder="Amount Paid" value="">--}}
              {{--</div>--}}

              <!-- GET THE DISPLAY OPTIONS -->
              {{--<div class="form-group  col-md-12 ">--}}
                {{--<label class="control-label" for="name">Change</label>--}}
                {{--<input type="number" class="form-control" name="change" required="" step="any" placeholder="Change"--}}
                       {{--value="">--}}
              {{--</div>--}}

              <!-- GET THE DISPLAY OPTIONS -->
              {{--<div class="form-group  col-md-12 ">--}}

                {{--<label class="control-label" for="name">User Id</label>--}}
                {{--<input type="number" class="form-control" name="user_id" required="" step="any" placeholder="User Id"--}}
                       {{--value="">--}}
              {{--</div>--}}

              <!-- GET THE DISPLAY OPTIONS -->
              {{--<div class="form-group  col-md-12 ">--}}

                {{--<label class="control-label" for="name">sale_items</label>--}}
                {{--<ul>--}}
                {{--</ul>--}}

              {{--</div>--}}

            {{--</div><!-- panel-body -->--}}

            {{--<div class="panel-footer">--}}
              {{--<button type="submit" class="btn btn-primary save">Save</button>--}}
            {{--</div>--}}
          {{--</form>--}}

        {{--</div>--}}
      {{--</div>--}}
    {{--</div>--}}
  </div>

  <div class="modal fade modal-danger" id="confirm_delete_modal">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"
                  aria-hidden="true">&times;
          </button>
          <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
        </div>

        <div class="modal-body">
          <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default"
                  data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
          <button type="button" class="btn btn-danger"
                  id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End Delete File Modal -->
@stop

@section('javascript')
  <script>
      var params = {};
      var $file;

      function deleteHandler(tag, isMulti) {
          return function () {
              $file = $(this).siblings(tag);

              params = {
                  slug: '{{ $dataType->slug }}',
                  filename: $file.data('file-name'),
                  id: $file.data('id'),
                  field: $file.parent().data('field-name'),
                  multi: isMulti,
                  _token: '{{ csrf_token() }}'
              }

              $('.confirm_delete_name').text(params.filename);
              $('#confirm_delete_modal').modal('show');
          };
      }

      $('document').ready(function () {
          $('.toggleswitch').bootstrapToggle();

          //Init datepicker for date fields if data-datepicker attribute defined
          //or if browser does not handle date inputs
          $('.form-group input[type=date]').each(function (idx, elt) {
              if (elt.type != 'date' || elt.hasAttribute('data-datepicker')) {
                  elt.type = 'text';
                  $(elt).datetimepicker($(elt).data('datepicker'));
              }
          });

        @if ($isModelTranslatable)
        $('.side-body').multilingual({"editing": true});
        @endif

        $('.side-body input[data-slug-origin]').each(function (i, el) {
            $(el).slugify();
        });

          $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
          $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
          $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
          $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

          $('#confirm_delete').on('click', function () {
              $.post('{{ route('voyager.media.remove') }}', params, function (response) {
                  if (response
                      && response.data
                      && response.data.status
                      && response.data.status == 200) {

                      toastr.success(response.data.message);
                      $file.parent().fadeOut(300, function () {
                          $(this).remove();
                      })
                  } else {
                      toastr.error("Error removing file.");
                  }
              });

              $('#confirm_delete_modal').modal('hide');
          });
          $('[data-toggle="tooltip"]').tooltip();
      });
  </script>
@stop
