@extends('layouts.backend.app')
@section('title', config('title.ruang_title')['module'])
@section('subtitle', 'Halaman '.config('title.ruang_title')['module'])
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
        {!! Form::model($data, ['method' => 'PATCH','route' => [config('global.ruang')['url'].'.update', $data->id]]) !!}
        @else
        {!! Form::open(array('route' => config('global.ruang')['url'].'.store','method'=>'POST')) !!}
        @endif
        <div class="row">
            <div class="col-sm-9">
                <div class="mb-3">
                    <label class="form-label" for="formrow-firstname-input">{{ config('title.ruang_title')['name'] }}</label>
                    {!! Form::text(config('global.ruang_field')['name'], (!is_null($data)?$data->nama_layanan:null), array('placeholder' => config('title.ruang_title')['name'],'class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="mb-3">
                    <label class="form-label" for="formrow-firstname-input">{{ config('title.ruang_title')['kode'] }}</label>
                    {!! Form::text(config('global.ruang_field')['kode'], (!is_null($data)?$data->kode_layanan:null), array('placeholder' => config('title.ruang_title')['kode'],'class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">{{ config('title.ruang_title')['unit'] }}</label>
                {!! Form::select(config('global.ruang_field')['service_unit'], $unit,(!is_null($data)?$data->group_layanan_id:null), array('placeholder' => config('title.ruang_title')['unit'],'class' => 'form-control')) !!}
            </div>
            </div>
            
        </div>
        <div class="mb-3 form-check form-switch form-switch-md ">
            <label class="form-label" for="formrow-firstname-input">{{ config('title.status')}}</label>
            {!! Form::checkbox('data_status', (!is_null($data)?$data->data_status:true),(!is_null($data)?$data->data_status:true), array('class' => 'form-check-input')) !!}
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary w-md">{{ config('global.button')['save'] }}</button>
            <a href="@php echo route(config('global.ruang')['url'].'.index') @endphp" type="reset" class="btn btn-danger w-md">
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