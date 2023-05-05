@extends('layouts.backend.app')
@section('title', config('title.layanan'))
@section('subtitle', 'Halaman '.config('title.layanan'))
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">@yield('subtitle')</h4>
                
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
        {!! Form::model($data, ['method' => 'PATCH','route' => [config('global.layanan')['url'].'.update', $data->id]]) !!}
        @else
        {!! Form::open(array('route' => config('global.layanan')['url'].'.store','method'=>'POST')) !!}
        @endif
        <div class="col-sm-12">
                <div class="mb-3">
                    <label class="form-label" for="formrow-firstname-input">{{ config('title.layanan_title')['name'] }}</label>
                    {!! Form::text(config('global.layanan_field')['name'], (!is_null($data)?$data->nama_layanan:null), array('placeholder' => config('title.layanan_title')['name'],'class' => 'form-control')) !!}
                </div>
            </div>
            
        <div class="row">
            <div class="col-sm-9">
                <div class="mb-3">
                    <label class="form-label" for="formrow-firstname-input">{{ config('title.layanan_title')['jasa'] }}</label>
                    {!! Form::select(config('global.layanan_field')['jasa'],$jasadokter, (!is_null($data)?$data->jasa_dokter_id:null), array('placeholder' => config('title.layanan_title')['jasa'],'class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="mb-3">
                    <label class="form-label" for="formrow-firstname-input">{{ config('title.layanan_title')['kode'] }}</label>
                    {!! Form::text(config('global.layanan_field')['kode'], (!is_null($data)?$data->kode_layanan:null), array('placeholder' => config('title.layanan_title')['kode'],'class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">{{ config('title.layanan_title')['group'] }}</label>
                {!! Form::select(config('global.layanan_field')['group'], $group,(!is_null($data)?$data->group_layanan_id:null), array('placeholder' => config('title.layanan_title')['group'],'class' => 'form-control')) !!}
            </div>
            </div>
            <div class="col-sm-6">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">{{ config('title.layanan_title')['rekening'] }}</label>
                {!! Form::select(config('global.layanan_field')['rekening'], $rekening,(!is_null($data)?$data->kode_rekening_id:null), array('placeholder' => config('title.layanan_title')['group'],'class' => 'form-control')) !!}
            </div>
            </div>
        </div>
        <b>Tarif Onsite</b>
        <div class="row">
            <div class="col-sm-6">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">{{ config('title.layanan_tarif_title')['tarif'] }}</label>
                {!! Form::text(config('global.layanan_tarif_field')['tarif'], (!is_null($data_tarif)?$data_tarif->tarif:0), array('placeholder' => config('title.layanan_tarif_title')['tarif'],'class' => 'form-control')) !!}
            </div>
            </div>
            <div class="col-sm-6">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">{{ config('title.layanan_tarif_title')['diskon'] }}</label>
                {!! Form::text(config('global.layanan_tarif_field')['diskon'], (!is_null($data_tarif)?$data_tarif->diskon:0), array('placeholder' => config('title.layanan_tarif_title')['diskon'],'class' => 'form-control')) !!}
            </div>
            </div>
        </div>
        <b>Tarif Online</b>
        <div class="row">
            <div class="col-sm-6">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">{{ config('title.layanan_tarif_title')['tarif'] }}</label>
                {!! Form::text('tarif_online', (!is_null($data_tarif_online)?$data_tarif_online->tarif:0), array('placeholder' => config('title.layanan_tarif_title')['tarif'],'class' => 'form-control')) !!}
            </div>
            </div>
            <div class="col-sm-6">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">{{ config('title.layanan_tarif_title')['diskon'] }}</label>
                {!! Form::text('diskon_online', (!is_null($data_tarif_online)?$data_tarif_online->diskon:0), array('placeholder' => config('title.layanan_tarif_title')['diskon'],'class' => 'form-control')) !!}
            </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="formrow-firstname-input">Biaya Admin Praktisi</label>
            {!! Form::select('merger_layanan_id',$merger, (!is_null($data)?$data->merger_layanan_id:null), array('placeholder' => config('title.layanan_title')['jasa'],'class' => 'form-control')) !!}
        </div>
        <div class="mb-3 form-check form-switch form-switch-md ">
            <label class="form-label" for="formrow-firstname-input">{{ config('title.status')}}</label>
            {!! Form::checkbox('data_status', (!is_null($data)?$data->data_status:true),(!is_null($data)?$data->data_status:true), array('class' => 'form-check-input')) !!}
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary w-md">{{ config('global.button')['save'] }}</button>
            <a href="@php echo route(config('global.layanan')['url'].'.index') @endphp" type="reset" class="btn btn-danger w-md">
                {{ config('global.button')['cancel'] }}
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