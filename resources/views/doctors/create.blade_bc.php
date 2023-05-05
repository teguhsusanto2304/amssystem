@extends('layouts.backend.app')
@section('title', 'Dokter')
@section('subtitle', 'Halaman Tambah Dokter Baru')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Tambah Dokter baru</h4>
                
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


{!! Form::open(array('route' => 'doctors.store','method'=>'POST')) !!}
    <div class="row">  
        <div class="col-md-2">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">Gelar Depan</label>
                        {!! Form::text('gelar_depan', null, array('placeholder' => 'gelar depan','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-md-7">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">Nama Lengkap</label>
                        {!! Form::text('nama', null, array('placeholder' => 'nama lengkap','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">Gelar Belakang</label>
                        {!! Form::text('gelar_belakang', null, array('placeholder' => 'gelar belakang','class' => 'form-control')) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">Jenis Kelamin</label>
                        {!! Form::select('jenis_kelamin',['Lelaki','Perempuan'], null, array('placeholder' => 'Pilih','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">Tanggal Lahir</label>
                        {!! Form::date('tgl_lahir', null, array('placeholder' => 'Pilih','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">No Handphone</label>
                        {!! Form::text('no_handphone', null, array('placeholder' => 'No handphone','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">NIP</label>
                        {!! Form::text('NIP', null, array('placeholder' => 'NIP','class' => 'form-control')) !!}
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="mb-3">
            <label class="form-label" for="formrow-firstname-input">Alamat</label>
                    {!! Form::text('alamat', null, array('placeholder' => 'alamat lengkap','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">Spesialis</label>
                        {!! Form::select('spesialis',$speciality, null, array('placeholder' => 'Pilih','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">Unit Kerja</label>
                        {!! Form::select('unit_kerja',$unit, null, array('placeholder' => 'Pilih','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">Tipe Tenaga Medis</label>
                        {!! Form::select('unit_kerja',$unit, null, array('placeholder' => 'Pilih','class' => 'form-control')) !!}
            </div>
        </div>
    </div>
        
        <div class="mt-4">
            <button type="submit" class="btn btn-primary w-md">Submit</button>
            <a href="{{ route('doctors.index') }}" type="reset" class="btn btn-danger w-md">
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
@endsection