@extends('layouts.backend.app')
@section('title', 'Dokter')
@section('subtitle', 'Halaman Tambah Dokter Baru')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Tambah Jadwal Dokter baru</h4>
                
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


{!! Form::open(array('route' => 'doctor_schedules.store','method'=>'POST')) !!}
<div class="col-md-12">
    <div class="mb-3">
    <label class="form-label" for="formrow-firstname-input">Dokter</label>
            {!! Form::select('dokter',$doctors, null, array('placeholder' => 'pilih dokter','class' => 'form-control')) !!}
    </div>
</div>
    <div class="row">
        <div class="col-md-2">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">Hari</label>
                        {!! Form::select('hari',$days, null, array('placeholder' => 'Pilih','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">Mulai</label>
                        {!! Form::time('jam_mulai', null, array('placeholder' => '00:00','class' => 'form-control','type'=>'time')) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">Selesai</label>
                        {!! Form::time('jam_selesai', null, array('placeholder' => '00:00','class' => 'form-control','type'=>'time')) !!}
            </div>
        </div>
    </div>
    
    
        
        <div class="mt-4">
            <button type="submit" class="btn btn-primary w-md">Submit</button>
            <a href="{{ route('doctor_schedules.index') }}" type="reset" class="btn btn-danger w-md">
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