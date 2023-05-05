@extends('layouts.backend.app')
@section('title', 'Pembayaran')
@section('subtitle', 'Halaman Pembayaran Tagihan Pasien')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Pembayaran Tagihan Pasien</h4>
                
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


{!! Form::open(array('route' => ['keuangan.pembayaran.create',$dtkunjungan->reg_id],'method'=>'POST')) !!}
<div class="mb-3">
    <div class="col-sm-5">
        <label class="form-label" for="formrow-firstname-input">Total Tagihan</label>
        <div class="input-group mb-2">
            {!! Form::text('total', $total->sub_total, array('placeholder' => 'No Kartu Bank','class' => 'form-control','readonly'=>true)) !!}
        </div>
    </div>
    <div class="col-sm-5">
        <label class="form-label" for="formrow-firstname-input">Dibayarkan</label>
        <div class="input-group mb-2">
            {!! Form::text('bayar', 0, array('placeholder' => 'No Kartu Bank','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-sm-5">
        <label class="form-label" for="formrow-firstname-input">Sisa</label>
        <div class="input-group mb-2">
            {!! Form::text('sisa', 0, array('placeholder' => 'No Kartu Bank','class' => 'form-control')) !!}
        </div>
    </div>
        <div class="col-sm-5">
            <label class="form-label" for="formrow-firstname-input">Metode</label>
            <div class="input-group mb-2">
                {!! Form::select('metode', $metode,null, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-5">
            <label class="form-label" for="formrow-firstname-input">Bank</label>
            <div class="input-group mb-2">
                {!! Form::select('bank', $bank,null, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-5">
            <label class="form-label" for="formrow-firstname-input">No Kartu</label>
            <div class="input-group mb-2">
                {!! Form::text('no_kartu', null, array('placeholder' => 'No Kartu Bank','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-8">
            <label class="form-label" for="formrow-firstname-input">Pembayar</label>
            <div class="input-group mb-2">
                {!! Form::text('pembayar', $dtpasien->fullname, array('placeholder' => 'gelar depan','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary w-md">Submit</button>
            <a href="{{ route('keuangan.transaksi',$dtkunjungan->reg_id) }}" type="reset" class="btn btn-danger w-md">
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