@extends('layouts.backend.appdatatable')
@section('title', config('title.ruang_title')['module'])
@section('subtitle', 'Halaman '.config('title.ruang_title')['module'])
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">@yield('subtitle')</h4>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route(config('global.ruang')['url'].'.create') }}"> Tambah @yield('title')</a>
                </div>
                <br>

                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                  <p>{{ $message }}</p>
                </div>
                @endif
                <table id="datatable" class="table table-bordered dt-responsive nowrap data-table table-striped table-primary" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th width="2%">No</th>
                            <th>{{ config('title.ruang_title')['name'] }}</th>
                            <th>{{ config('title.ruang_title')['kode'] }}</th>
                            <th>{{ config('title.ruang_title')['unit'] }}</th>
                            <th width="2%">{{ config('title.status') }}</th>
                            <th width="4%">{{ config('title.action') }}</th>
                        </tr>
                    </thead>

                    
                </table>

            </div>
        </div>
    </div>
            </div>
        </div>
    </div>
    <!-- end col -->
</div>
<!-- end row -->
<script src="{{ asset('template/backend') }}/libs/jquery/jquery.min.js"></script>
<script type="text/javascript">

    $(function () {
      
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route(config('global.ruang')['url'].'.index') }}",
          columns: [
              {data: 'DT_RowIndex' , name: 'id'},
              {data: 'nama_ruang', name: 'nama_ruang'},
              {data: 'kode_ruang', name: 'kode_ruang'},
              {data: 'service_unit', name: 'service_unit'},
              {data: 'data_status', name: 'data_status'},
              {data: 'action', name: 'action', orderable: false, searchable: true},
          ]
      });
    });
  
    
  </script>
@endsection

