@extends('layouts.backend.app')
@section('title', 'Rekam Medis')
@section('subtitle', 'Halaman Tambah Rekam Medis Baru')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Tambah @yield('title') Baru</h4>
                
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
                            {!! Form::open(array('route' => 'rekammedis.store','method'=>'POST')) !!}
                                <div class="row">                                                            
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Panggilan</label>
                                            {!! Form::select('title',['Bpk' => 'Bapak', 'Ibu' => 'Ibu', 'Sdr' => 'Saudara', 'Sdri' => 'Saudari', 'Ank' => 'Anak', 'By' => 'Bayi', 'Inf' => 'Inf'],null, array('placeholder' => 'Pilih','class' => 'form-control')) !!}
                                        </div>
                                    </div> <!-- end col -->
                                    <div class="col-md-10">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Nama</label>
                                            {!! Form::text('fullname', null, array('placeholder' => 'Nama lengkap','class' => 'form-control')) !!}
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                                <div class="row">                                                            
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Gender</label>
                                            {!! Form::select('gender',['Lelaki' => 'Lelaki', 'Perempuan' => 'Perempuan'],null, array('placeholder' => 'Pilih','class' => 'form-control')) !!}
                                        </div>
                                    </div> <!-- end col -->
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Tgl Lahir</label>
                                            {!! Form::date('date_of_birth', null, array('placeholder' => 'Tgl Lahir','class' => 'form-control')) !!}
                                        </div>
                                    </div> <!-- end col -->
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Gol darah</label>
                                            {!! Form::select('blood_type',['AB' => 'AB', 'A' => 'A', 'B' => 'B', 'O' => 'O'],null, array('placeholder' => 'Pilih','class' => 'form-control')) !!}
                                        </div>
                                    </div> <!-- end col -->
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Status Pernikahan</label>
                                            {!! Form::select('marital_status',['1' => 'Belum Menikah', '2' => 'Menikah', '3' => 'Janda', '4' => 'Duda'],null, array('placeholder' => 'Pilih','class' => 'form-control')) !!}
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Alamat</label>
                                    {!! Form::text('address', null, array('placeholder' => 'Alamat','class' => 'form-control')) !!}
                                </div>
                                <div class="row"> 
                                    <div class="col-md-2">                                                           
                                    <div class="mb-3">
                                        <label class="form-label" for="formrow-email-input">Kode Pos</label>
                                            {!! Form::text('postalcode', null, array('placeholder' => 'Kode pos','class' => 'form-control')) !!}
                                    </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Jenis Identitas</label>
                                            {!! Form::select('identity_type',['1' => 'KTP', '2' => 'Passpor', '3' => 'Kitas', '4' => 'KTA'],null, array('placeholder' => 'Pilih','class' => 'form-control')) !!}
                                        </div>
                                    </div> <!-- end col -->
                                    <div class="col-md-7">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Nomor Ientitas</label>
                                            {!! Form::text('identity_number',null, array('placeholder' => 'Nomor Identitas','class' => 'form-control')) !!}
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row"> 
                                    <div class="col-md-3">                                                           
                                    <div class="mb-3">
                                        <label class="form-label" for="formrow-email-input">Pendidikan</label>
                                        {!! Form::select('ducation_id',$education,null, array('placeholder' => 'Pilih','class' => 'form-control')) !!}
                                    </div> 
                                    </div>
                                    <div class="col-md-3">                                                           
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-email-input">Pekerjaan</label>
                                            {!! Form::select('work_id',$work,null, array('placeholder' => 'Pilih','class' => 'form-control')) !!}
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">No Handphone</label>
                                            {!! Form::text('phone_number',null, array('placeholder' => 'No Handphone','class' => 'form-control')) !!}
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary w-md">Submit</button>
                                    <a href="{{ route('rekammedis.index') }}" type="reset" class="btn btn-danger w-md">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div> <!-- end col -->
                    
                    </form><!-- end form -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Form Layout -->



{!! Form::close() !!}

@endsection