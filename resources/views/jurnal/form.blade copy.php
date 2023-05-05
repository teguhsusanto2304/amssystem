@extends('layouts.backend.app')
@section('title', 'Jurnal')
@section('subtitle', 'Halaman Jurnal')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Jurnal</h4>
                
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
        {!! Form::model($data, ['method' => 'PATCH','route' => ['jeniskunjungans.update', $data->id]]) !!}
        @else
        {!! Form::open(array('route' => 'jurnals.store','method'=>'POST')) !!}
        @endif
        <div class="mb-3">
            <label class="form-label" for="formrow-firstname-input">Rekening Asal</label>
            {!! Form::select('source_kode_rekening_id',$coa,(!is_null($data)?$data->kode_rekening_id:null), array('placeholder' => 'Pilih Kode Rekening','class' => 'form-control')) !!}
        </div>
        <div class="mb-3">
            <label class="form-label" for="formrow-firstname-input">Rekening Tujuan</label>
            {!! Form::select('dest_kode_rekening_id',$coa,(!is_null($data)?$data->kode_rekening_id:null), array('placeholder' => 'Pilih Kode Rekening','class' => 'form-control')) !!}
        </div>
        <div class="row"> 
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label" for="formrow-password-input">Position</label>
                    {!! Form::select('position',['Balance Sheet (Neraca)','Income Statement (Laba Rugi)'],(!is_null($data)?$data->kode_rekening_id:null), array('placeholder' => 'Jenis Transaksi','class' => 'form-control')) !!}
                </div>
            </div> <!-- end col -->
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label" for="formrow-password-input">Jenis Transaksi</label>
                {!! Form::select('jenis',['Debit','Kredit'],(!is_null($data)?$data->kode_rekening_id:null), array('placeholder' => 'Jenis Transaksi','class' => 'form-control')) !!}
            </div>
        </div> <!-- end col -->
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label" for="formrow-password-input">Jumlah Rp.</label>
                {!! Form::number('jumlah', (!is_null($data)?$data->jumlah:null), array('placeholder' => 'Jumlah','class' => 'form-control')) !!}
            </div>
        </div> <!-- end col -->
        </div>
        <div class="mb-12">
            <label class="form-label" for="formrow-firstname-input">Deskripsi</label>
            {!! Form::textarea('deskripsi', null, ['id' => 'deskripsi', 'rows' => 4, 'cols' => 54, 'class' => 'form-control']) !!}
        </div>
        <div class="mb-12">
            <label class="form-label" for="formrow-firstname-input">Remark I</label>
            {!! Form::textarea('remark1', null, ['id' => 'deskripsi', 'rows' => 4, 'cols' => 54, 'class' => 'form-control']) !!}
        </div>
        <div class="mb-12">
            <label class="form-label" for="formrow-firstname-input">Remark II</label>
            {!! Form::textarea('remark2', null, ['id' => 'deskripsi', 'rows' => 4, 'cols' => 54, 'class' => 'form-control']) !!}
        </div>
        <div class="mb-12">
            <label class="form-label" for="formrow-firstname-input">Remark III</label>
            {!! Form::textarea('remark3', null, ['id' => 'deskripsi', 'rows' => 4, 'cols' => 54, 'class' => 'form-control']) !!}
        </div>
        <div class="mb-3 form-check form-switch form-switch-md ">
            <label class="form-label" for="formrow-firstname-input">Status</label>
            {!! Form::checkbox('data_status', (!is_null($data)?$data->data_status:null),(!is_null($data)?$data->data_status:true), array('class' => 'form-check-input')) !!}
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary w-md">Submit</button>
            <a href="{{ route('jurnals.index') }}" type="reset" class="btn btn-danger w-md">
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