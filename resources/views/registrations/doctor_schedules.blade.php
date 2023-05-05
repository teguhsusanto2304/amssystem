@extends('layouts.backend.appdatatable')
@section('title', 'Doctor Schedule')
@section('subtitle', 'Halaman Doctor Schedule')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">@yield('subtitle')</h4>
                <table id="datatable" class="table table-bordered dt-responsive nowrap data-table table-striped table-primary" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th width="2%">No</th>
                            <th>Nama</th>
                            <th>Unit Kerja</th>
                            <th>Hari</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
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
      var name = 1;
      var poli = 2;
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          columnDefs: [
            { "visible": false, "targets": name },
            { "visible": false, "targets": poli }
        ],
        order: [[ poli, 'asc' ]],
        "displayLength": 25,
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(poli, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="8"><h5>'+group+'<h5></td></tr>'
                    );
 
                    last = group;
                }
            } );
            api.column(name, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="8"><strong>'+group+'</strong></td></tr>'
                    );
 
                    last = group;
                }
            } );
        },
          ajax: "{{ route('registrations.doctors.search',$rekammedis->id) }}",
          // columnDefs: [{"render": createManageBtn, "data": null, "targets": [7]}],
          columns: [
              {data: 'DT_RowIndex' , name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'service_unit', name: 'service_unit'},
              {data: 'hari', name: 'hari'},
              {data: 'jam_mulai', name: 'jam_mulai'},
              {data: 'jam_akhir', name: 'jam_akhir'},
              {data: 'data_status', name: 'data_status'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });
    function createManageBtn() {
        //return '<a href="{{ route("registrations.create",["rekammedis"=>1,"doctor"=>1]) }}" class="btn btn-primary btn-sm ml-2 btn-edit">Pilih</a>';
            //return '<button id="manageBtn" type="button" onclick="myFunc()" class="btn btn-success btn-xs">Manage</button>';
        }
        function myFunc() {
            alert('teguh');
            console.log("Button was clicked!!!");
        }
  
  
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

