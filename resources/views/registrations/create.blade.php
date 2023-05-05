@extends('layouts.backend.app')
@section('title', 'Registrations')
@section('subtitle', 'Halaman Tambah Kunjungan Pasien')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Tambah Kunjungan Pasien</h4>
                
                <div class="row">
                    <div class="col-lg-8">
                        @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
                @endif
                        <div class="mt-4">


{!! Form::open(array('route' => 'registrations.store','method'=>'POST','id'=>'frmData')) !!}
<h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary me-1"></i> Informasi Pasien</h5>
        <div class="row gx-12 gy-2 align-items-center" style="margin-bottom: 30px;">
            <div class="col-sm-8">
                <label class="form-label" for="formrow-firstname-input">Nama</label>
                <div class="input-group mb-3">
                {!! Form::text('name', $rekammedis->fullname, array('placeholder' => 'Name','class' => 'form-control','disabled'=>true)) !!}
                <a href="{{ route('registrations.patient.search')}}" class="btn btn-primary"  id="button-addon2"><i class="fas fa-user" ></i></a>
                </div>
            </div>
            <div class="col-sm-3">
                <label class="form-label" for="formrow-firstname-input">No Rekam medis</label>
                <div class="input-group mb-3">
                {!! Form::text('name', $rekammedis->medical_record_no, array('placeholder' => 'Name','class' => 'form-control','disabled'=>true)) !!}
                </div>
            </div>
        </div>
        <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary me-1"></i> Informasi Dokter</h5>
        <div class="row gx-12 gy-2 align-items-center" style="margin-bottom: 30px;">
            <div class="col-sm-8">
                <label class="form-label" for="formrow-firstname-input">Nama</label>
                <div class="input-group mb-3">
                {!! Form::hidden('rekam_medis_id', $rekammedis->id, array('id' => 'rekam_medis_id')) !!}
                {!! Form::text('name', $dokter['dokter_name'], array('placeholder' => 'Name','class' => 'form-control','disabled'=>true)) !!}
                <a href="{{ route('registrations.doctors.search',$rekammedis->id)}}" class="btn btn-primary"  id="button-addon2"><i class="fas fa-user-nurse" ></i></a>
                </div>
                {!! Form::hidden('dokter_id', $dokter['id'], array('id' => 'dokter_id')) !!}
                {!! Form::hidden('service_unit_id', $dokter['service_unit_id'], array('id' => 'service_unit_id')) !!}
            </div>
            <div class="col-sm-4">
                <label class="form-label" for="formrow-firstname-input">Spesialis</label>
                <div class="input-group mb-3">
                {!! Form::text('name', $dokter['speciality'], array('placeholder' => 'Name','class' => 'form-control','disabled'=>true)) !!}
                </div>
            </div>
            <div class="col-sm-8">
                <label class="form-label" for="formrow-firstname-input">Poliklinik</label>
                {!! Form::text('name', $dokter['service_unit'], array('placeholder' => 'Name','class' => 'form-control','disabled'=>true)) !!}
            </div>
            <div class="col-sm-4">
                <label class="form-label" for="formrow-firstname-input">Jadwal</label>
                {!! Form::text('name', $dokter['jadwal'], array('placeholder' => 'Name','class' => 'form-control','disabled'=>true)) !!}
            </div>
        </div>
        <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary me-1"></i> Informasi Kunjungan</h5>
        <div class="row gx-12 gy-2 align-items-center" style="margin-bottom: 30px;">
            <div class="col-sm-6">
                <label class="form-label" for="formrow-firstname-input">Jenis kunjungan</label>
                {!! Form::select('jenis_kunjungan_id',$jenis_kunjungan, 1, array('placeholder' => 'Pilih','class' => 'form-control')) !!}
            </div>
            <div class="col-sm-6">
                <label class="form-label" for="formrow-firstname-input">Jenis Perwatan</label>
                {!! Form::select('jenis_perawatan_id',$jenis_perawatan, 1, array('placeholder' => 'Pilih','class' => 'form-control')) !!}
            </div>
            <div class="col-sm-6">
                <label class="form-label" for="formrow-firstname-input">Penanggung Jawab</label>
                <div class="input-group mb-3">
                {!! Form::select('penanggung',$penanggung, 0, array('placeholder' => 'Pilih','class' => 'selectpicker form-control','data-container'=>'body')) !!}
                    <button class="btn btn-primary" type="button" id="button-addon2"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            <div class="col-sm-6">
                <label class="form-label" for="formrow-firstname-input">Asuransi/Perusahaan</label>
                <div class="input-group mb-3">
                {!! Form::select('penjamin_id',$penjamin, 0, array('class' => 'custom-select form-control','data-container'=>'body')) !!}
                    <button class="btn btn-primary" type="button" id="button-addon2"><i class="fas fa-plus"></i></button>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary w-md" id="btn-submit">Submit</button>
            <a href="{{ route('registrations.index') }}" type="reset" class="btn btn-danger w-md">
                Cancel
            </a>
        </div>
    </div> <!-- end col -->
</div>
</div>
</div>
</div>
</div>
<!-- End Form Layout -->
{!! Form::close() !!}
<script src="{{ asset('template/backend') }}/libs/jquery/jquery.min.js"></script>
<script type="text/javascript">
$(document).on('click', '#btn-submit', function(e) {
    e.preventDefault();
    Swal.fire({
            title:"Konfirmasi Registrasi",
            text:"apakah anda yakin akana registrasikan pasien",
            icon:"confirm",
            showCancelButton:!0,
            confirmButtonColor:"#34c38f",
            cancelButtonColor:"#f46a6a",
            cancelButtonText:"Batal",
            confirmButtonText:"Ya, Registrasikan"}).then(function (result){
                if(result.value==true){                    
                    $('#frmData').submit();
                }
    });
});
    </script>
@endsection