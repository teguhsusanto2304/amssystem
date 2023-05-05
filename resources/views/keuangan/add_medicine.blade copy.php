@extends('layouts.backend.app')
@section('title', 'Tambah Transaksi Obat')
@section('subtitle', 'Halaman Tambah Transaksi Obat')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Tambah Transaksi Obat</h4>
                
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


{!! Form::open(array('route' => ['farmasi.transaksi.savemedicine',$kunjungan],'method'=>'POST')) !!}
<div class="mb-3">
    <label class="form-label" for="formrow-firstname-input">Name</label>
            {!! Form::select('obat', $obat,null, array('class' => 'form-control')) !!}
        </div>
        <div class="col-sm-5">
            <label class="form-label" for="formrow-firstname-input">Satuan</label>
                    {!! Form::select('satuan', $satuan,null, array('class' => 'form-control')) !!}
                </div>
        <div class="col-sm-2">
            <label class="form-label" for="formrow-firstname-input">Qty</label>
            <div class="input-group mb-2">
            {!! Form::number('qty', 1, array('class' => 'form-control select2','id'=>'qty')) !!}
        </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary w-md">Submit</button>
            <a href="{{ route('farmasi.transaksi',$kunjungan) }}" type="reset" class="btn btn-danger w-md">
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
<script>
    $(document).ready(function() {
    $('#qty').select2();
});
    </script>
@endsection