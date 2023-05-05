@extends('layouts.backend.appdatatable')
@section('title', 'Kunjungan Pasien Poliklinik')
@section('subtitle', 'Halaman Kunjungan Pasien Poliklinik')
@section('content')
<style>
    .red {
  background-color: red !important;
}
</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">@yield('subtitle')</h4>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('registrations.patient.search') }}"> Create New Registration</a>
                </div>
                <p class="card-title-desc">The Buttons extension for DataTables provides a common set of options, API methods and styling to display buttons on a page that will interact with a DataTable. The core library provides the based framework upon which plug-ins can built.
                </p>

                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                  <p>{{ $message }}</p>
                </div>
                @endif
                <table id="datatable" class="table table-bordered dt-responsive nowrap data-table table-striped table-primary" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th >No</th>
                            <th>Nama</th>
                            <th>No Rekam Medis</th>
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
        var doctor = 3;
      var poli = 4;
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          //dom: 'Bfrtip',

          drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(poli, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"  ><td colspan="7" style="background-color:Orange"><h5>'+group+'<h5></td></tr>'
                    );
 
                    last = group;
                }
            } );
            api.column(doctor, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="7"><strong>'+group+'</strong></td></tr>'
                    );
 
                    last = group;
                }
            } );
        },
          ajax: "{{ route('registrations.index') }}",
          columns: [
            {data: 'no_registrasi' , name: 'no_registrasi',searchable: false},
              {data: 'fullname', name: 'rekam_medis.fullname'},
              {data: 'medical_record_no', name: 'rekam_medis.medical_record_no',searchable: false},
              {data: 'dokter', name: 'doctors.fullname',searchable: true,"visible": false, "targets": doctor},
              {data: 'service_unit', name: 'service_units.service_unit',searchable: false,"visible": false, "targets": poli},
              {data: 'no_antrian', name: 'kunjungan_pasiens.no_antrian',searchable: false},
              {data: 'kunjungan_at', name: 'kunjungan_pasiens.kunjungan_at',searchable: false},
              {data: 'data_status', name: 'data_status',searchable: false},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
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

