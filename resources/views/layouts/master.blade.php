<!DOCTYPE html>
<html>
<head>
  <title>@yield('title') | {{env('APP_NAME')}}</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- CSRF Token -->
  <meta name="_token" content="{{ csrf_token() }}">
  
  <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">
  
  <!-- plugin css -->
  {!! Html::style('assets/plugins/@mdi/font/css/materialdesignicons.min.css') !!}
  {!! Html::style('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') !!}
  <!-- end plugin css -->
  
  
  {!! Html::style('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')!!}
  {!! Html::style('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')!!}
  {!! Html::style('plugins/datatables-responsive/css/responsive.bootstrap4.css')!!}
  {!! Html::style('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')!!}
  {!! Html::style('plugins/datatables-fixedcolumns/css/fixedColumns.bootstrap4.min.css')!!}    
  {!! Html::style('plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css')!!}

  <!-- Select2 -->
  {!! Html::style('/plugins/select2/css/select2.min.css')!!}
  {!! Html::style('/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')!!}

  {!! Html::style('plugins/bootstrap-tagsinput-latest/src/bootstrap-tagsinput.css')!!}


  @stack('plugin-styles')

  <!-- common css -->
  {!! Html::style('css/app.css') !!}
  <!-- end common css -->

  @stack('style')
</head>
<body data-base-url="{{url('/')}}">

  <div class="container-scroller" id="app">
    @include('layouts.header')
    <div class="container-fluid page-body-wrapper">
      @include('layouts.sidebar')
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
        @include('layouts.footer')
      </div>
    </div>
  </div>

  <!-- jQuery -->
  {!! Html::script('plugins/jquery/jquery.min.js') !!}
  <!-- JQuery -->

  <!-- jQuery UI 1.11.4 -->
  {!! Html::script('plugins/jquery-ui/jquery-ui.min.js') !!}
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>


  <!-- Bootstrap 4 -->
  {!! Html::script('/plugins/bootstrap/js/bootstrap.bundle.min.js') !!}
  
  <!-- DataTables  & Plugins -->
  {!! Html::script('plugins/datatables/jquery.dataTables.min.js') !!}
  {!! Html::script('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') !!}

  {!! Html::script('/plugins/datatables-buttons/js/dataTables.buttons.min.js') !!}
  {!! Html::script('/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') !!}
  {!! Html::script('/plugins/jszip/jszip.min.js') !!}
  {!! Html::script('/plugins/pdfmake/pdfmake.min.js') !!}
  {!! Html::script('/plugins/pdfmake/vfs_fonts.js') !!}
  {!! Html::script('/plugins/datatables-buttons/js/buttons.html5.min.js') !!}
  {!! Html::script('/plugins/datatables-buttons/js/buttons.print.min.js') !!}
  {!! Html::script('/plugins/datatables-buttons/js/buttons.colVis.min.js') !!}
  <!-- Select2 -->
  {!! Html::script('/plugins/select2/js/select2.full.min.js') !!}

  
  <!-- daterangepicker -->
  {!! Html::script('/plugins/moment/moment.min.js') !!}
  {!! Html::script('/plugins/daterangepicker/daterangepicker.js') !!}
  <!-- Tempusdominus Bootstrap 4 -->
  {!! Html::script('/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') !!}
  <script src="https://cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>

  {!! Html::script('plugins/bootstrap-tagsinput-latest/src/bootstrap-tagsinput.js') !!}
  <!-- base js -->
  <!-- {!! Html::script('js/app.js') !!} -->
  {!! Html::script('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') !!}
  <!-- end base js -->

  <!-- plugin js -->
  @stack('plugin-scripts')
  <!-- end plugin js -->

  <!-- common js -->
  {!! Html::script('assets/js/off-canvas.js') !!}
  {!! Html::script('assets/js/hoverable-collapse.js') !!}
  {!! Html::script('assets/js/misc.js') !!}
  {!! Html::script('assets/js/settings.js') !!}
  {!! Html::script('assets/js/todolist.js') !!}
  <!-- end common js -->

  <!-- jquery-validation -->
  {!! Html::script('/plugins/jquery-validation/jquery.validate.min.js') !!}
  {!! Html::script('/plugins/jquery-validation/additional-methods.min.js') !!}
  
  <script>
    $(function() {
      // $.noConflict();
      $('.select2').select2();

      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })

      $('.datepicker').datetimepicker({
        format: 'L'
      });
    });
  </script>
  @stack('custom-scripts')
  
</body>
</html>