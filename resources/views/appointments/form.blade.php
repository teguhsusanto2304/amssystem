@extends('layouts.backend.appdatatable')
@section('title', $config['title'])
@section('subtitle', $config['subtitle'])
@section('content')
@if(!is_null($data))
{!! Form::model($data, ['method' => 'PATCH','route' => [$config['update_url'], $data->id]]) !!}
@else
{!! Form::open(array('route' => $config['post_url'],'method'=>'POST')) !!}
@endif

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Appointment</h4>
                <div class="row">
                    <div class="row">
                        <div class="col-lg-8">
                            @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Peringatan!</strong> ada beberapa masalah pada data yang anda input<br><br>
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                    @endif
                        </div>
                    <div class="col-lg-10">
                        <div class="mt-5">
                            <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary me-1"></i> Pasien</h5>
                            <div class="row">                                                            
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="formrow-password-input">No Rekam Medis</label>
                                        <div class="input-group mb-3">
                                            {{ Form::text('medical_record_no', null, array('readonly'=>true,'id'=>'medical_record_no','placeholder' => 'No RM','class' => 'form-control')) }}
                                            <button class="btn btn-primary" id="btnCari" type="button" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl"><i class="fas fa-search" ></i></button>
                                            <button class="btn btn-warning" id="btnResetPasien" type="button" ><i class="fas fa-eraser" ></i></button>
                                            <!--  Modal content for the above example -->
                                            <div id="pasienModal" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
                                            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Pencarian Pasien</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
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
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger waves-effect"
                                                            data-bs-dismiss="modal">{{ config('global.button')['cancel'] }}</button>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                            </div>
                                            <!-- end modal -->
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                        </div>
                        <div class="row">                                                            
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-password-input">Panggilan</label>
                                        {{ Form::select('title',['Bpk' => 'Bapak', 'Ibu' => 'Ibu', 'Sdr' => 'Saudara', 'Sdri' => 'Saudari', 'Ank' => 'Anak', 'By' => 'Bayi', 'Inf' => 'Inf'],null, array('id'=>'title','placeholder' => 'Pilih','class' => 'form-control '.(!empty($errors->first('title'))?'is-invalid':''))) }}
                                        @error('title') <small class="text-danger"> {{ $errors->first('title') }}</small> @enderror
                                </div>
                            </div> <!-- end col -->
                            <div class="col-md-9">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-password-input">Nama</label>
                                    {{ Form::text('fullname', null, array('id'=>'fullname','placeholder' => 'Nama lengkap','class' => 'form-control '.(!empty($errors->first('fullname'))?'is-invalid':''))) }}
                                    @error('fullname') <small class="text-danger"> {{ $errors->first('fullname') }}</small> @enderror
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                        <div class="row">                                                            
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-password-input">Jenis kelamin</label>
                                        {{ Form::select('gender',['Perempuan' => 'perempuan', 'Lelaki' => 'Lelaki'],null, array('id'=>'gender','placeholder' => 'Pilih','class' => 'form-control '.(!empty($errors->first('gender'))?'is-invalid':''))) }}
                                        @error('gender') <small class="text-danger"> {{ $errors->first('gender') }}</small> @enderror
                                </div>
                            </div> <!-- end col -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-password-input">Phone Number</label>
                                    {{ Form::text('phone_number',null, array('id'=>'phone_number','placeholder' => 'Phone Number','class' => 'form-control')) }}
                                </div>
                            </div> <!-- end col -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">{{ $config['column'][3] }}</label>
                                    {{ Form::date(config('global.appointment_field')['dob'], (!is_null($data)?$data->prosentase_appointment_dokter:null), array('id'=>config('global.appointment_field')['dob'],'readonly'=>false,'placeholder' => $config['column'][2],'class' => 'form-control '.(!empty($errors->first('fullname'))?'is-invalid':''))) }}
                                    @error(config('global.appointment_field')['dob']) <small class="text-danger"> {{ $errors->first(config('global.appointment_field')['dob']) }}</small> @enderror
                                </div>
                            </div> <!-- end col -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">{{ $config['column'][4] }}</label>
                                    {{ Form::text('usia',null, array('id'=>'usia','readonly' => true,'class' => 'form-control')) }}
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                        <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary me-1"></i> Dokter</h5>
                        <div class="row"> 
                            <div class="col-sm-5">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Dokter</label>
                                    <div class="input-group mb-3">
                                    {!! Form::hidden(config('global.appointment_field')['dokter_id'],null,array('id'=>'dokter_id')) !!}
                                    {!! Form::hidden(config('global.appointment_field')['service_unit_id'],null,array('id'=>'service_unit_id')) !!}
                                    {!! Form::text('nama_dokter', (!is_null($data)?$data->prosentase_rumah_sakit:null), array('id'=>'nama_dokter','placeholder' => 'nama dokter','class' => 'form-control '.(!empty($errors->first('dokter_id'))?'is-invalid':''))) !!}
                                    <button class="btn btn-primary" id="btnCariDokter" type="button" data-bs-toggle="modal" data-bs-target=".bs-dokter-modal-xl"><i class="fas fa-search" ></i></button>
                                    </div>
                                    @error('dokter_id') <small class="text-danger"> {{ $errors->first('dokter_id') }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Poliklinik</label>
                                    {!! Form::text('unit', (!is_null($data)?$data->prosentase_appointment_dokter:null), array('id' => 'service_unit','class' => 'form-control','readonly'=>true)) !!}
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Jadwal</label>
                                    {!! Form::text('jadwal', (!is_null($data)?$data->prosentase_appointment_dokter:null), array('id' => 'jadwal','class' => 'form-control','readonly'=>true)) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Tgl Appointment</label>
                                    {{ Form::date('appointment_at', (!is_null($data)?$data->appointment_at:null), array('id'=>'appointment_at','readonly'=>false,'placeholder' => $config['column'][2],'class' => 'form-control  '.(!empty($errors->first('appointment_at'))?'is-invalid':''))) }}
                                    @error('appointment_at') <small class="text-danger"> {{ $errors->first('appointment_at') }}</small> @enderror
                                </div>
                            </div> <!-- end col -->
                        </div>
<!-- start -->
<!--  Modal content for the above example -->
<div id="dokternModal" class="modal fade bs-dokter-modal-xl" tabindex="-1" role="dialog"
aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Pencarian Dokter</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered dt-responsive nowrap table-striped table-primary" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th width="2%">No</th>
                        <th>Nama</th>
                        <th>Unit Kerja</th>
                        <th>Hari</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th width="4%">Aksi</th>
                    </tr>
                </thead>
            @foreach($config['jadwal'] as $row)
            <tr>
                <td width="2%">{{ $row['id'].' - '.$row['service_unit_id'] }}</td>
                <td>{{ $row['name'] }}</td>
                <td>{{ $row['service_unit'] }}</td>
                <td>{{ $row['hari'] }}</td>
                <td>{{ $row['jam_mulai'] }}</td>
                <td>{{ $row['jam_akhir'] }}</td>
                <td width="4%"><button type="button"  onclick=" rowDokterDataGet (' {{ $row['id'] }}','{{ $row['name'] }}','{{ $row['service_unit'] }}','{{ $row['jam_mulai'].' - '.$row['jam_akhir'] }}','{{ $row['service_unit_id'] }}') " class="btn btn-primary" >Pilih</button></td>
            </tr>
            @endforeach
        </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger waves-effect"
                data-bs-dismiss="modal">{{ config('global.button')['cancel'] }}</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>
        <div class="mb-3 form-check form-switch form-switch-md ">
            <label class="form-label" for="formrow-firstname-input">{{ config('title.status')}}</label>
            {!! Form::checkbox('data_status', (!is_null($data)?$data->data_status:true),(!is_null($data)?$data->data_status:true), array('class' => 'form-check-input')) !!}
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary w-md">{{ config('global.button')['save'] }}</button>
            <a href="{{ route($config['list_url']) }}" type="reset" class="btn btn-danger w-md">
                {{ config('global.button')['cancel'] }}
            </a>
        </div>
    </div> <!-- end col -->
</div>

<!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{!! Form::close() !!}
<script src="{{ asset('template/backend') }}/libs/jquery/jquery.min.js"></script>
<script type="text/javascript">
   $(function () {
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          scrollY:"250px",
          ajax: "{{ route('registrations.patient.search') }}",
          select: {style:'single'},
          columns: [
              {data: 'DT_RowIndex' , name: 'id'},
              {data: 'profile', name: 'profile'},
              {data: 'address', name: 'address'},
              {data: 'action', name: 'action', orderable: false, searchable: true},
              {data: 'medical_record_no', name: 'medical_record_no',visible: false},
              {data: 'fullname', name: 'fullname',visible: false},
              {data: 'title', name: 'title',visible: false},
              {data: 'date_of_birth', name: 'date_of_birth',visible: false},
              {data: 'gender', name: 'gender',visible: false},
              {data: 'phone_number', name: 'phone_number',visible: false},
          ],
          "columnDefs": [
        {
          "render" : function(data,type,row){
            return "<div class=\"btn-group\"> <button type=\"button\"  onclick=\" rowDataGet ('"+row['medical_record_no']+"','"+row['fullname']+"','"+row['title']+"','"+row['date_of_birth']+"','"+row['gender']+"','"+row['phone_number']+"') \" class=\"btn btn-primary\" >Pilih</button></div>"
          },
          "targets" : 3
        }
      ],
      });
      $("#date_of_birth").on("input", function(){ 
        $("#usia").val(getAge($("#date_of_birth").val()));
    });
      $('#keyword').keyup(function() {
        keyword = $(this).val();
            table.ajax.url("{{ route('registrations.patient.search') }}?keyword="+keyword).load();
        });
        $('#datatable1 tbody1').on('click', 'tr', function () {
            var data = table.row(this).data();
            alert('You clicked on ' + data['medical_record_no'] + "'s row");
            $('#medical_record_no').val(data['medical_record_no']);
            $('#fullname').val(data['fullname']);
            $('#pasienModal').modal('hide');
        });
        $('#datatable tbody1').on('click1', function () {
            var data = table.row(this).data();
            alert('You clicked on ' + data['medical_record_no'] + "'s row");
            $('#medical_record_no').val(data['medical_record_no']);
            $('#fullname').val(data['fullname']);
            $('#pasienModal').modal('hide');
        });
    });
    $('#btnResetPasien').on('click',function () {
        $('#medical_record_no').val('');
        $('#fullname').val('');
        $('#title').val('');
        $('#date_of_birth').val('');
        $('#gender').val('');
        $('#phone_number').val('');
        $('#medical_record_no').attr('readonly', true);
        $('#fullname').attr('readonly', false);
        $('#title').attr('readonly', false);
        $('#date_of_birth').attr('readonly', false);
        $('#gender').attr('readonly', false);
        $('#phone_number').attr('readonly', false);
        $("#usia").val("");
    });
    function rowDataGet (a,b,c,d,e,f) {
        $('#medical_record_no').val(a);
        $('#fullname').val(b);
        $('#title').val(c);
        $('#date_of_birth').val(d);
        $("#usia").val(getAge(d));
        $('#gender').val(e);
        $('#phone_number').val(f);
        $('#medical_record_no').attr('readonly', true);
        $('#fullname').attr('readonly', true);
        $('#title').attr('readonly', true);
        $('#date_of_birth').attr('readonly', true);
        $('#gender').attr('readonly', true);
        $('#phone_number').attr('readonly', true);
        $('#pasienModal').modal('hide');
    }
    function rowDokterDataGet (a,b,c,d,e) {
        //alert(e);
        $('#nama_dokter').val(b);
        $('#dokter_id').val(a);
        $('#service_unit').val(c);
        $('#service_unit_id').val(e);
        $('#jadwal').val(d);
        $('#dokternModal').modal('hide');
    }
    function getAge(dateString){
        var now = new Date();
  var today = new Date(now.getYear(),now.getMonth(),now.getDate());

  var yearNow = now.getYear();
  var monthNow = now.getMonth();
  var dateNow = now.getDate();

var dob = new Date(dateString);
  var yearDob = dob.getYear();
  var monthDob = dob.getMonth();
  var dateDob = dob.getDate();
  var age = {};
  var ageString = "";
  var yearString = "";
  var monthString = "";
  var dayString = "";


  yearAge = yearNow - yearDob;

  if (monthNow >= monthDob)
    var monthAge = monthNow - monthDob;
  else {
    yearAge--;
    var monthAge = 12 + monthNow -monthDob;
  }

  if (dateNow >= dateDob)
    var dateAge = dateNow - dateDob;
  else {
    monthAge--;
    var dateAge = 31 + dateNow - dateDob;

    if (monthAge < 0) {
      monthAge = 11;
      yearAge--;
    }
  }

  age = {
      years: yearAge,
      months: monthAge,
      days: dateAge
      };

  if ( age.years > 1 ) yearString = " th";
  else yearString = " th";
  if ( age.months> 1 ) monthString = " bln";
  else monthString = " bln";
  if ( age.days > 1 ) dayString = " hr";
  else dayString = " hr";


  if ( (age.years > 0) && (age.months > 0) && (age.days > 0) )
    ageString = age.years + yearString + ", " + age.months + monthString + ", " + age.days + dayString;
  else if ( (age.years == 0) && (age.months == 0) && (age.days > 0) )
    ageString = "Only " + age.days + dayString
  else if ( (age.years > 0) && (age.months == 0) && (age.days == 0) )
    ageString = age.years + yearString ;
  else if ( (age.years > 0) && (age.months > 0) && (age.days == 0) )
    ageString = age.years + yearString + " and " + age.months + monthString ;
  else if ( (age.years == 0) && (age.months > 0) && (age.days > 0) )
    ageString = age.months + monthString + " and " + age.days + dayString ;
  else if ( (age.years > 0) && (age.months == 0) && (age.days > 0) )
    ageString = age.years + yearString + " and " + age.days + dayString ;
  else if ( (age.years == 0) && (age.months > 0) && (age.days == 0) )
    ageString = age.months + monthString ;
  else ageString = "Oops! Could not calculate age!";

  return ageString;
      }
    
    </script>
@endsection