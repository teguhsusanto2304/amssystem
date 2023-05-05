@extends('layouts.backend.app')
@section('title', 'Spesialis Tenaga Medis')
@section('subtitle', 'Halaman Spesialis Tenaga Medis')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Jenis Perawatan</h4>
                
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
                        <div class="mt-4">
        @if(!is_null($data))
        {!! Form::model($data, ['method' => 'PATCH','route' => ['specialities.update', $data->id]]) !!}
        @else
        {!! Form::open(array('route' => 'specialities.store','method'=>'POST')) !!}
        @endif
        <div class="mb-3">
            <label class="form-label" for="formrow-firstname-input">Jenis Kunjungan</label>
            {!! Form::text('speciality', (!is_null($data)?$data->Speciality:null), array('placeholder' => 'Spesialis','class' => 'form-control')) !!}
        </div>
        <div class="mb-3 form-check form-switch form-switch-md ">
            <label class="form-label" for="formrow-firstname-input">Status</label>
            {!! Form::checkbox('data_status', (!is_null($data)?$data->data_status:null),(!is_null($data)?$data->data_status:true), array('class' => 'form-check-input')) !!}
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary w-md">Submit</button>
            <a href="{{ route('specialities.index') }}" type="reset" class="btn btn-danger w-md">
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