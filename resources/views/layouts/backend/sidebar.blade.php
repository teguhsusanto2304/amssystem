<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Main</li>

                <li>
                    <a href="{{ route('home') }}" class="waves-effect">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="badge rounded-pill bg-primary float-end">2</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                @can('user-list')
                <li>
                    <a href="{{ route('users.index') }}" class=" waves-effect">
                        <i class="mdi mdi-account-box"></i>
                        <span>Manajemen User @can('role-list') @endcan</span>
                    </a>
                </li>
                @endcan
                @can('role-list')
                <li>
                    <a href="{{ route('roles.index') }}" class=" waves-effect">
                        <i class="mdi mdi-account-box"></i>
                        <span>Role Access</span>
                    </a>
                </li>
                @endcan
                @can('medical-record-list')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-email-outline"></i>
                        <span>Rekam Medis</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('medical-record-list')
                        <li><a href="{{ route('medicalrecords.index') }}">Rekam Medis</a></li>
                        @endcan
                        @can('medical-record-list')
                        <li><a href="{{ route('cities.index') }}">Coding Diagnosa</a></li>
                        @endcan
                        @can('medical-record-list')
                        <li><a href="{{ route('districts.index') }}">Laporan</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('medical-record-list')
                <li class="mm-active">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-email-outline"></i>
                        <span>Kunjungan Poliklinik</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false" >
                        @can('appointment-list')
                        <li ><a href="{{ route('appointments.index') }}">List Appointment</a></li>
                        @endcan
                        @can('medical-record-list')
                        <li ><a href="{{ route('registrations.index') }}">List Kunjungan</a></li>
                        @endcan
                        @can('medical-record-list')
                        <li ><a href="{{ route('registrations.online') }}">List Konsultasi Online</a></li>
                        @endcan
                        @can('medical-record-list')
                        <li><a href="{{ route('cities.index') }}">Buat Registrasi Kunjungan</a></li>
                        @endcan
                        @can('medical-record-list')
                        <li><a href="{{ route('districts.index') }}">Laporan</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('doctor-list')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-email-outline"></i>
                        <span>Manajemen Dokter</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('doctor-list')
                        <li><a href="{{ route('doctors.index') }}">List Dokter</a></li>
                        @endcan
                        @can('doctor-create')
                        <li><a href="{{ route('doctors.create') }}">Tambah Dokter Baru</a></li>
                        @endcan
                        @can('doctor-list')
                        <li><a href="{{ route('doctor_schedules.index') }}">Manajemen Jadwal Dokter</a></li>
                        @endcan
                        @can('doctor-list')
                        <li><a href="{{ route('doctorfees.index') }}">Manajemen Jasa Medis Dokter</a></li>
                        @endcan
                        @can('spesialis-list')
                        <li><a href="{{ route('specialities.index') }}">Spesialis Dokter</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('apotek-kunjungan-list')
                <li class="mm-active">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-email-outline"></i>
                        <span>Kunjungan Pasien</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false" >
                        @can('apotek-kunjungan-list')
                        <li ><a href="{{ route('farmasi.kunjungan.pasien') }}">List Kunjungan</a></li>
                        @endcan
                        @can('registration-list')
                        <li><a href="{{ route('districts.index') }}">Laporan</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('kasir-kunjungan-list')
                <li class="mm-active">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-email-outline"></i>
                        <span>Kunjungan Pasien</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false" >
                        @can('kasir-kunjungan-list')
                        <li ><a href="{{ route('keuangan.kunjungan.pasien') }}">List Kunjungan</a></li>
                        @endcan
                        @can('layanan-list')
                        <li ><a href="{{ route('keuangan.kunjungan.pasien') }}">List Kunjungan</a></li>
                        @endcan
                        @can('registration-list')
                        <li><a href="{{ route('districts.index') }}">Laporan</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('doctor-list')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-email-outline"></i>
                        <span>Manajemen Tenaga Medis</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('doctor-list')
                        <li><a href="{{ route('doctors.index') }}">List Tenaga medis</a></li>
                        @endcan
                        @can('doctor-create')
                        <li><a href="{{ route('doctors.create') }}">Tambah Tenaga Medis Baru</a></li>
                        @endcan
                        @can('doctor-list')
                        <li><a href="{{ route('doctor_schedules.index') }}">Manajemen Jadwal Dokter</a></li>
                        @endcan
                        @can('doctor-list')
                        <li><a href="{{ route('doctorfees.index') }}">Manajemen Jasa Medis Dokter</a></li>
                        @endcan
                        @can('doctor-list')
                        <li><a href="{{ route('districts.index') }}">Laporan</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-email-outline"></i>
                        <span>Akuntansi</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route("koderekenings.index") }}">COA</a></li>
                        <li><a href="{{ route("jurnals.index") }}">Jurnal</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-email-outline"></i>
                        <span>Master Data</span>
                    </a>
                    @can('layanan-list')
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <span>Layanan dan Tindakan</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @can('group-layanan-list')
                                <li ><a href="{{ route("grouplayanans.index") }}">Group Layanan/Tindakan</a></li>
                                @endcan
                                @can('layanan-list')
                                <li ><a href="{{ route("layanans.index") }}">Layanan/Tindakan</a></li>
                                @endcan
                                @can('layanan-unit-list')
                                <li ><a href="{{ route("layananunits.index") }}">Layanan/Tindakan Per Unit</a></li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <span>Lokasi</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    @can('ruang-list')
                                    <li ><a href="{{ route("rooms.index") }}">Ruang</a></li>
                                    @endcan
                                    @can('service-unit-list')
                                    <li><a href="{{ route('serviceunits.index') }}">Unit Layanan</a></li>
                                    @endcan
                                </ul>
                            </li>
                        @can('jenis-kunjungan-list')
                        <li><a href="{{ route('jeniskunjungans.index') }}">Jenis Kunjungan</a></li>
                        @endcan
                        @can('jenis-perawatan-list')
                        <li><a href="{{ route('jenisperawatans.index') }}">Jenis Perawatan</a></li>
                        @endcan
                        @can('province-list')
                        <li><a href="{{ route('provinces.index') }}">Provinsi</a></li>
                        @endcan
                        @can('city-list')
                        <li><a href="{{ route('cities.index') }}">Kota/Kabupaten</a></li>
                        @endcan
                        @can('district-list')
                        <li><a href="{{ route('districts.index') }}">Kecamatan/District</a></li>
                        @endcan
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->