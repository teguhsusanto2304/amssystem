@extends('layouts.backend.appdatatable')
@section('title', config('title.layanan'))
@section('subtitle', 'Halaman '.config('title.layanan'))
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">@yield('subtitle')</h4>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route(config('global.layanan')['url'].'.create') }}"> Tambah @yield('title')</a>
                </div>
                <br>

                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                  <p>{{ $message }}</p>
                </div>
                @endif
                <table id="datatable" class="table table-bordered nowrap data-table table-striped table-primary" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th width="2%">No</th>
                            <th>{{ config('title.layanan_title')['name'] }}</th>
                            <th>{{ config('title.layanan_title')['kode'] }}</th>
                            <th>{{ config('title.layanan_title')['group'] }}</th>
                            <th>{{ config('title.layanan_title')['rekening'] }}</th>
                            <th>{{ config('title.layanan_title')['jasa'] }}</th>
                            <th>{{ config('title.layanan_tarif_title')['tarif'] }}</th>
                            <th>{{ config('title.layanan_tarif_title')['diskon'] }}</th>
                            <th>{{ config('title.layanan_tarif_title')['tarif'] }} Online</th>
                            <th>{{ config('title.layanan_tarif_title')['diskon'] }} Online</th>
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
<style>
    .text-right {
    text-align: right;
}
    </style>
<script src="{{ asset('template/backend') }}/libs/jquery/jquery.min.js"></script>
<script type="text/javascript">

    $(function () {
      
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          scrollX: true,
          ajax: "{{ route(config('global.layanan')['url'].'.index') }}",
          columns: [
              {data: 'DT_RowIndex' , name: 'id'},
              {data: 'nama_layanan', name: 'nama_layanan'},
              {data: 'kode_layanan', name: 'kode_layanan'},
              {data: 'group_layanan', name: 'group_layanans.group_layanan'},
              {data: 'nama_rekening', name: 'kode_rekenings.nama_rekening'},
              {data: 'nama_jasa_dokter', render:function(data,type,row){
                if(row.nama_jasa_dokter!=null){
                    return row.nama_jasa_dokter+'<br><small>Dokter : '+row.prosentase_jasa_dokter+' %  Klinik : '+row.prosentase_rumah_sakit+' %</small>';
                } else {
                    return null;
                }
              },className: "text-center"},
              {data: 'tarif', name: 'layanan_tarifs.tarif',className: "text-right",render: $.fn.dataTable.render.number( ',', '.', 2, '' )},
              {data: 'diskon', name: 'layanan_tarifs.diskon',className: "text-right",render: $.fn.dataTable.render.number( ',', '.', 2, '' )},
              {data: 'tarif_online', name: 'layanan_tarif_online.tarif',className: "text-right",render: $.fn.dataTable.render.number( ',', '.', 2, '' )},
              {data: 'diskon_online', name: 'layanan_tarif_online.diskon',className: "text-right",render: $.fn.dataTable.render.number( ',', '.', 2, '' )},
              {data: 'data_status', name: 'data_status'},
              {data: 'action', name: 'action', orderable: false, searchable: true},
          ]
      });
    });
  
    
  </script>
@endsection

