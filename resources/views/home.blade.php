@extends('layouts.backend.app')
@section('title', 'Dashboard')
@section('subtitle', 'Halaman Dashboard')
@section('content')
<div class="row">
    <div class="col-xl-3 col-sm-6">
        <div class="card mini-stat bg-primary">
            <div class="card-body mini-stat-img">
                <div class="mini-stat-icon">
                    <i class="mdi mdi-cube-outline float-end"></i>
                </div>
                <div class="text-white">
                    <h6 class="text-uppercase mb-3 font-size-16 text-white">Jumlah Pasien</h6>
                    <h2 class="mb-4 text-white">300</h2>
                    <span class="ms-2">Perhari ini</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card mini-stat bg-primary">
            <div class="card-body mini-stat-img">
                <div class="mini-stat-icon">
                    <i class="mdi mdi-buffer float-end"></i>
                </div>
                <div class="text-white">
                    <h6 class="text-uppercase mb-3 font-size-16 text-white">Pendapatan</h6>
                    <h2 class="mb-4 text-white">5.5 Juta</h2>
                    <span class="badge bg-danger"> -29% </span> <span class="ms-2">Dari periode kemarin</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card mini-stat bg-primary">
            <div class="card-body mini-stat-img">
                <div class="mini-stat-icon">
                    <i class="mdi mdi-tag-text-outline float-end"></i>
                </div>
                <div class="text-white">
                    <h6 class="text-uppercase mb-3 font-size-16 text-white">Biaya</h6>
                    <h2 class="mb-4 text-white">1.5 Juta</h2>
                    <span class="badge bg-warning"> 0% </span> <span class="ms-2">Dari periode kemarin</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card mini-stat bg-primary">
            <div class="card-body mini-stat-img">
                <div class="mini-stat-icon">
                    <i class="mdi mdi-briefcase-check float-end"></i>
                </div>
                <div class="text-white">
                    <h6 class="text-uppercase mb-3 font-size-16 text-white">Hutang dagang</h6>
                    <h2 class="mb-4 text-white">2.6 Juta</h2>
                    <span class="badge bg-info"> +2% </span> <span class="ms-2">Dari periode kemarin</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

<div class="row">

    <div class="col-xl-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Demografi pasien</h4>

                <div class="row text-center mt-4">
                    <div class="col-6">
                        <h5 class="font-size-20">250</h5>
                        <p class="text-muted">Permpuan</p>
                    </div>
                    <div class="col-6">
                        <h5 class="font-size-20">50</h5>
                        <p class="text-muted">Lelaki</p>
                    </div>
                </div>

                <div id="morris-donut-example" data-colors='["#f0f1f4","--bs-primary","--bs-info"]' class="morris-charts morris-charts-height" dir="ltr"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Kunjungan Pasien Per poliklinik</h4>

                <div class="row text-center mt-4">
                    <div class="col-4">
                        <h5 class="font-size-20">345</h5>
                        <p class="text-muted">Obsgyn</p>
                    </div>
                    <div class="col-4">
                        <h5 class="font-size-20">230</h5>
                        <p class="text-muted">Anak</p>
                    </div>
                    <div class="col-4">
                        <h5 class="font-size-20">543</h5>
                        <p class="text-muted">Umum</p>
                    </div>
                </div>

                <div id="morris-area-example" data-colors='["#f0f1f4","--bs-primary","--bs-info"]' class="morris-charts morris-charts-height" dir="ltr"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Grafik Keuangan Unit dalam satu bulan</h4>

                <div class="row text-center mt-4">
                    <div class="col-6">
                        <h5 class="font-size-20">150 Juta</h5>
                        <p class="text-muted">Pendapatan</p>
                    </div>
                    <div class="col-6">
                        <h5 class="font-size-20">54</h5>
                        <p class="text-muted">Biaya</p>
                    </div>
                </div>

                <div id="morris-bar-stacked" data-colors='["--bs-info","#f0f1f4"]' class="morris-charts morris-charts-height" dir="ltr"></div>
            </div>
        </div>
    </div>

</div>
<!-- end row -->
@endsection