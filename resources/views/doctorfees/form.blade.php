@extends('layouts.backend.app')
@section('title', $config['title'])
@section('subtitle', $config['subtitle'])
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
        {!! Form::model($data, ['method' => 'PATCH','route' => [$config['update_url'], $data->id]]) !!}
        @else
        {!! Form::open(array('route' => $config['post_url'],'method'=>'POST')) !!}
        @endif
        <div class="col-sm-12">
            <div class="mb-3">
                <label class="form-label" for="formrow-firstname-input">{{ $config['column'][1] }}</label>
                {!! Form::text(config('global.jasa_field')['name'], (!is_null($data)?$data->nama_jasa_dokter:null), array('placeholder' => config('title.jasa_title')['name'],'class' => 'form-control')) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="mb-3">
                    <label class="form-label" for="formrow-firstname-input">{{ $config['column'][2] }}</label>
                    {!! Form::number(config('global.jasa_field')['prosen_dokter'], (!is_null($data)?$data->prosentase_jasa_dokter:null), array('placeholder' => $config['column'][2],'class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="mb-3">
                    <label class="form-label" for="formrow-firstname-input">{{ $config['column'][3] }}</label>
                    {!! Form::number(config('global.jasa_field')['prosen_rumah_sakit'], (!is_null($data)?$data->prosentase_rumah_sakit:null), array('placeholder' => $config['column'][3],'class' => 'form-control')) !!}
                </div>
            </div>
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
</div>
</div>
</div>
</div>
<!-- End Form Layout -->
{!! Form::close() !!}
@endsection