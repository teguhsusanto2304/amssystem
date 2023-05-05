@extends('layouts.backend.appdatatable')
@section('title', 'Konsultasi Online')
@section('subtitle', 'Halaman Konsultasi Online')
@section('content')
<style>
    .red {
  background-color: red !important;
}
</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body ">

                <h4 class="card-title">@yield('subtitle')</h4>
                <div class="row">
                    <div class="col-md-7"></div>
                        <div class="col-md-5">
                            <div class="mb-3">
                                <div class="input-group mb-3">
                                    <input type="date" id="tanggal" class="form-control" placeholder="Something clever.." value="{{ date('Y-m-d') }}">
                                    <button class="btn btn-primary" id="btnCari" type="button"><i class="fas fa-search" ></i></button>
                                    @can('registration-create')
                                        <a class="btn btn-success" href="{{ route('registrations.create.online') }}"> @yield('title') Baru</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                  <p>{{ $message }}</p>
                </div>
                @endif
                <table id="datatable" class="table table-bordered nowrap data-table table-primary" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th >No</th>
                            <th >No Registrasi</th>
                            <th>Nama</th>
                            <th>No Rekam Medis</th>
                            <th>Usia</th>
                            <th>Gender</th>
                            <th>Dokter</th>
                            <th>Unit</th>
                            <th>No Antrian</th>
                            <th>Tgl Registrasi</th>
                            <th width="2%">Status</th>
                            <th width="4%">Aksi</th>
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
        var doctor = 6;
      var poli = 7;
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          //dom: 'Bfrtip',
          scrollX:true,
          drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(poli, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"  ><td colspan="10"><h5>'+group+'<h5></td></tr>'
                    );
 
                    last = group;
                }
            } );
            api.column(doctor, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="10"><strong>'+group+'</strong></td></tr>'
                    );
 
                    last = group;
                }
            } );
        },
          ajax: "{{ route('registrations.index') }}?tanggal={{ date('Y-m-d') }}",
          columns: [
            {data: 'DT_RowIndex' , name: 'id'},
            {data: 'no_registrasi' , name: 'no_registrasi',searchable: false},
              {data: 'fullname', name: 'rekam_medis.fullname'},
              {data: 'medical_record_no', name: 'rekam_medis.medical_record_no',searchable: false},
              {data: 'age', name: 'age',searchable: false},
              {data: 'gender', name: 'rekam_medis.gender',searchable: false},
              {data: 'dokter', name: 'doctors.fullname',searchable: true,"visible": false, "targets": doctor},
              {data: 'service_unit', name: 'service_units.service_unit',searchable: false,"visible": false, "targets": poli},
              {data: 'no_antrian', name: 'kunjungan_pasiens.no_antrian',searchable: false},
              {data: 'kunjungan_at', name: 'kunjungan_pasiens.kunjungan_at',searchable: false},
              {data: 'data_status', name: 'data_status',searchable: false},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          createdRow: (row, data, dataIndex, cells) => {
                $(cells[0]).css('background-color', data['warna']);
            }
      });
      $('#btnCari').click(function() {
            tanggal = $('#tanggal').val();
            table.ajax.url("{{ route('registrations.index') }}?tanggal="+tanggal).load();
        });
    });
  
  
      // Reset Form
          function resetForm(){
              $("[name='name']").val("")
              $("[name='code']").val("")
              $("[name='data_status']").val("")
          }
      //
  
      // Create 
  
      $("#createForm").on("submit",function(e){
          e.preventDefault()
  
          $.ajax({
              url: "/admin/task-categories",
              method: "POST",
              data: $(this).serialize(),
              success:function(){
                  $("#create-modal").modal("hide")
                  $('.data-table').DataTable().ajax.reload();
                  flash("success","Data berhasil ditambah")
                  resetForm()
              }
          })
      })
  
      // Create
  
      // Edit & Update
      $('body').on("click",".btn-edit",function(){
          var id = $(this).attr("id")
          
          $.ajax({
              url: "/admin/task-categories/"+id+"/edit",
              method: "GET",
              success:function(response){
                  $("#edit-modal").modal("show")
                  $("#id").val(response.id)
                  $("#name").val(response.name)
                  $("#code").val(response.code)
                  $("#data_status").val(response.data_status)
              }
          })
      });
  
      $("#editForm").on("submit",function(e){
          e.preventDefault()
          var id = $("#id").val()
  
          $.ajax({
              url: "/admin/task-categories/"+id,
              method: "PATCH",
              data: $(this).serialize(),
              success:function(){
                  $('.data-table').DataTable().ajax.reload();
                  $("#edit-modal").modal("hide")
                  flash("success","Data berhasil diupdate")
              }
          })
      })
      //Edit & Update
  
      $('body').on("click",".btn-delete",function(){
          var id = $(this).attr("id")
          $(".btn-destroy").attr("id",id)
          $("#destroy-modal").modal("show")
      });
  
      $(".btn-destroy").on("click",function(){
          var id = $(this).attr("id")
  
          $.ajax({
              url: "/admin/user/"+id,
              method: "DELETE",
              success:function(){
                  $("#destroy-modal").modal("hide")
                  $('.data-table').DataTable().ajax.reload();
                  flash('success','Data berhasil dihapus')
              }
          });
      })
  
      function flash(type,message){
          $(".notify").html(`<div class="alert alert-`+type+` alert-dismissible fade show" role="alert">
                                `+message+`
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>`)
      }
  
  </script>
@endsection

