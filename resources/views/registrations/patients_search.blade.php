@extends('layouts.backend.appdatatable')
@section('title', 'Patient Search')
@section('subtitle', 'Halaman Pencarian Rekam Medis Pasien')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pencarian Rekam Medis Pasien</h4>
                
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mt-4">
                            <div class="mb-3">
                            <label class="form-label" for="formrow-firstname-input">Kata Kunci Pencarian (Nama, No Rekam medis)</label>
                            <div class="input-group mb-2">   
                            {!! Form::text('keyword', null, array('placeholder' => 'Kata kunci pencarian','class' => 'form-control','id'=>'keyword')) !!}
                            <a class="btn btn-success" href="{{ route(config('global.medicalrecord_url').'.create') }}"> @php echo config('title.medicalrecord'); @endphp Baru</a>
                            </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap data-table table-striped table-primary" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th width="2%">No</th>
                                <th width="50%">Nama</th>
                                <th width="40%">Alamat</th>
                                <th width="4%">Aksi</th>
                            </tr>
                        </thead>
                    
                        
                    </table>
                </div>
            </div>
        </div>
</div>
<!-- End Form Layout -->
<script src="{{ asset('template/backend') }}/libs/jquery/jquery.min.js"></script>
<script type="text/javascript">

    $(function () {
      
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('registrations.patient.search') }}",
          columns: [
              {data: 'DT_RowIndex' , name: 'id'},
              {data: 'profile', name: 'profile'},
              {data: 'address', name: 'address'},
              {data: 'action', name: 'action', orderable: false, searchable: true},
          ]
      });
      $('#keyword').keyup(function() {
        keyword = $(this).val();
            table.ajax.url("{{ route('registrations.patient.search') }}?keyword="+keyword).load();
        });
    });
  </script>
@endsection