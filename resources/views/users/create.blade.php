@extends('layouts.backend.app')
@section('title', 'Manajemen User')
@section('subtitle', 'Halaman Tambah User Baru')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Tambah User baru</h4>
                
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
                            {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-firstname-input">Nama</label>
                                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="formrow-email-input">Email</label>
                                        {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                                </div>                
                                <div class="row">                                                            
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Password</label>
                                            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                                        </div>
                                    </div> <!-- end col -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="formrow-password-input">Confirm Password</label>
                                            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="mb-3">
                                    <label class="form-label" for="formrow-email-input">Role</label>
                                    {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary w-md">Submit</button>
                                    <a href="{{ route('users.index') }}" type="reset" class="btn btn-danger w-md">
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