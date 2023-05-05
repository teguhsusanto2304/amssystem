@extends('layouts.backend.appdatatable')
@section('title', 'Rekam Medis')
@section('subtitle', 'Halaman Rekam Medis')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">@yield('subtitle')</h4>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('medicalrecords.create') }}"> Create Rekam Medis</a>
                </div>
                <p class="card-title-desc">The Buttons extension for DataTables provides a common set of options, API methods and styling to display buttons on a page that will interact with a DataTable. The core library provides the based framework upon which plug-ins can built.
                </p>

                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                  <p>{{ $message }}</p>
                </div>
                @endif
                <table id="datatable" class="data-table display table table-striped stripe row-border order-column" style="border-collapse: collapse; border-spacing: 10; width: 130%;margin:10;">
                    <thead>
                        <tr>
                            <th width="3%">No</th>
                            <th width="30%">Nama</th>
                            <th width="60%">Alamat</th>
                            <th width="40%">Tgl Lahir</th>
                            <th width="40%">Gender</th>
                            <th width="40%">HP</th>
                            <th width="2%"></th>
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
          scrollY:        "300px",
    scrollX: true,
    scrollCollapse: true,
    serverSide: true,
    retrieve: true,
    fixedColumns:   {
            left: 2,
            right: 1
        },
          ajax: "{{ route('lain') }}",
          columns: [
              {data: 'medical_record_no' , name: 'medical_record_no'},
              {data: 'fullname', name: 'fullname'},
              {data: 'address', name: 'address'},
              {data: 'date_of_birth', name: 'date_of_birth'},
              {data: 'gender', name: 'gender'},
              {data: 'phone_number', name: 'phone_number'},
              {data: 'action', name: 'action', orderable: false, searchable: true},
          ],createdRow: (row, data, dataIndex, cells) => {
        $(cells[1]).css('background-color', '#f8f9fa');
        $(cells[0]).css('background-color', '#f8f9fa');
    }
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

