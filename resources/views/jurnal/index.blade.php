@extends('layouts.backend.appdatatable')
@section('title', 'Jurnal')
@section('subtitle', 'Halaman Transaksi Jurnal Akuntansi')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">@yield('subtitle')</h4>
                <div class="row">
                    <div class="col-md-7"></div>
                        <div class="col-md-5">
                            <div class="mb-3">
                                <div class="input-group mb-3">
                                    <input type="date" id="tanggal" class="form-control" placeholder="Something clever.." value="{{ date('Y-m-d') }}">
                                    <button class="btn btn-primary" id="btnCari" type="button"><i class="fas fa-search" ></i></button>
                                    @can('registration-create')
                                        <a class="btn btn-success" href="{{ route('jurnals.create') }}">  Tambah Jurnal Baru</a>
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
                <table id="datatable" class="table table-bordered data-table table-striped table-primary" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th width="2%">No</th>
                            <th>Reg No</th>
                            <th>Time Stamped</th>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Rekening Asal</th>
                            <th>Rekening Tujuan</th>
                            <th>Deskripsi</th>
                            <th>Remark I</th>
                            <th>Remark II</th>
                            <th>Remark III</th>
                            <th>Position</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Balance</th>
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
      
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          scrollX: true,
          ajax: "{{ route('jurnals.index') }}",
          columns: [
              {data: 'DT_RowIndex' , name: 'id'},
              {data: 'reg_no', name: 'reg_no'},
              {data: 'created_time', name: 'created_time'},
              {data: 'created_month', name: 'created_month'},
              {data: 'created_year', name: 'created_year'},
              {data: 'source_nama_rekening', name: 'source_nama_rekening'},
              {data: 'dest_nama_rekening', name: 'dest_nama_rekening'},
              {data: 'description',nama:'description'},
              {data: 'remark1',nama:'remark1'},
              {data: 'remark2',nama:'remark2'},
              {data: 'remark3',nama:'remark3'},
              {data: 'position',nama:'position'},
              {data: 'debit',nama:'debit'},
              {data: 'kredit',nama:'kredit'},
              {data: 'balance',nama:'balance'},
              {data: 'data_status', name: 'data_status'},
              {data: 'action', name: 'action', orderable: false, searchable: true},
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

